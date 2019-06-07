<?php
include 'libs\phpqrcode\qrlib.php';
generateQR($_POST['tamanoQR']);
guardarJson();
if (is_dir("utils\ResuelvoExplorando")) {
  deleteDir("utils\ResuelvoExplorando");
}
recurse_copy('utils/ResuelvoExplorando'.$_POST['espaciosDeUso'],"utils\ResuelvoExplorando");
renameEspaciosDeUso();
generarPDF();
comprimirCarpetas('utils/CodigosQR');
comprimirCarpetas('utils/ResuelvoExplorando');

//Guardar configuraciones historicas
$carpetaHistorica = 'Configuraciones Historicas/'.date("Y-m-d H_i_s").'/';
mkdir($carpetaHistorica,0777);
copy('utils/ResuelvoExplorando.zip',$carpetaHistorica.'ResuelvoExplorando.zip');
copy('utils/CodigosQR.zip',$carpetaHistorica.'CodigosQR.zip');

//Redirecionar
header("location:descargarZip.php?actividad=".$_POST['actNombre']."&espaciosDeUso=".$_POST['espaciosDeUso']);

function getActivity(){
  return new Actividad($_POST['actNombre'],$_POST['actObjetivo'],$_POST['inlineRadioOptions'],getTasks());
}

function getDepos(){
  $depos = array();
  for ($i=1; $i<=3 ; $i++){
    if (array_key_exists('depoCriterio'.$i,$_POST)) {
      $depoAux = new Deposito($_POST['depoCriterio'.$i],$_POST['depoDescripcion'.$i]);
      array_push($depos,$depoAux);
    }
  }
  return $depos;
}

function getTasks(){
  $tasks = array();
  for ($i=1; $i<=3 ; $i++){
    if (array_key_exists('t'.$i.'nombre',$_POST)) {
      $taskAux = new Task($_POST['t'.$i.'nombre'],$_POST['t'.$i.'desc'],$_POST['t'.$i.'con'],getElems($i),getExtras($i));
      array_push($tasks,$taskAux);
    }
  }
  return $tasks;
}

function getAllElems(){
  $elems = array();
  for ($i=1; $i<=3 ; $i++) {
    $taskElems = getElems($i);
    foreach ($taskElems as $index => $each) {
      array_push($elems,$each);
    }
  }
  return $elems;
}

function getElems($task){
  $elems = array();
  for ($i=1; $i<=$_POST['cantElems'.$task] ; $i++){
    if (array_key_exists('nombreelemento'.$task.'-'.$i,$_POST)) {
      $ok = true;
      if ($_POST['okelemento'.$task.'-'.$i] == 0) {
        $ok = false;
      }
      $elemAux = new Elemento($_POST['nombreelemento'.$task.'-'.$i],$_POST['descripcionelemento'.$task.'-'.$i],$_POST['depoelemento'.$task.'-'.$i],$ok,$task);
      array_push($elems,$elemAux);
    }
  }
  return $elems;
}

function getExtras($task){
  $extras = array();
  for ($i=1; $i<=$_POST['cantExtras'.$task] ; $i++){
    if (array_key_exists('nombreelemento'.$task.'-'.$i,$_POST)) {
      $extraAux = new Extra($_POST['tituloextra'.$task.'-'.$i],$_POST['contenidoextra'.$task.'-'.$i]);
      array_push($extras,$extraAux);
    }
  }
  return $extras;
}

class EA{
  public $languaje = '';
  public $educationalActivity = '';
  public $taskToRecolectDefinition = '';
  public $taskToDeposit = '';
  public $elements = '';

  function __construct($lang, $activity, $tasks, $depos, $elems)
  {
    $this->languaje = $lang;
    $this->educationalActivity = $activity;
    $this->taskToRecolectDefinition = $tasks;
    $this->taskToDeposit = $depos;
    $this->elements = $elems;
  }
}

class Actividad{
  public $Name = "";
  public $Goal = "";
  public $Code = "";
  public $taskToRecolect = array();

  function __construct($name, $goal, $code, $tasks)
  {
    $this->Name = $name;
    $this->Goal=$goal;
    $this->Code=$code;
    foreach ($tasks as $index => $task) {
      array_push($this->taskToRecolect,$task->getCode());
    }
  }
}

class Deposito{
  public $name = "";
  public $description = "";
  public $code = "";

  function __construct($cr, $desc)
  {
    $this->name = $cr;
    $this->description = $desc;
    $this->code = $this->getCode();
  }

  function getCode(){
    return eliminar_tildes(strtolower($this->name));
  }
}

class Elemento{
  public $Name = "";
  public $Description = "";
  public $Code = "";
  public $Deposits = array();
  public $ok = false;

  function __construct($nom, $desc, $depo, $correct, $task)
  {
    $this->Name = $nom;
    $this->Description = $desc;
    $this->Code = $this->genCode($task);
    array_push($this->Deposits,eliminar_tildes(strtolower($depo)));
    $this->ok=$correct;
  }

  function isCorrect(){
    return $this->ok;
  }

  function genCode($task) {
    return strtolower((eliminar_tildes($this->Name))."_T".$task);
  }
  function getCode(){
    return $this->Code;
  }
}

class Task{
  public $name = "";
  public $description = "";
  public $consigna = "";
  public $code = "";
  public $extras = array();
  public $elements = array();
  public $validElements = array();

  function __construct($nom, $desc, $cons, $elems, $extras)
  {
    $this->name = $nom;
    $this->description = $desc;
    $this->consigna = $cons;
    $this->code = $this->getCode();
    foreach ($elems as $index => $elem) {
      $this->addElem($elem);
    }
    foreach ($extras as $index => $extra) {
      $this->addExtra($extra);
    }
  }

  function addElem($elem){
    array_push($this->elements,$elem->getCode());
    if ($elem->isCorrect()) {
      array_push($this->validElements,$elem->getCode());
    }
  }

  function addExtra($extra){
    array_push($this->extras,$extra);
  }

  function getCode(){
    return eliminar_tildes(strtolower($this->name));
  }
}

class Extra{
  public $title = "";
  public $content = "";

  function __construct($tit, $cont)
  {
    $this->title = $tit;
    $this->content = $cont;
  }
}

function guardarJson(){
  $fichero = "utils/ResuelvoExplorando".$_POST['espaciosDeUso']."/Configuracion/ConfiguracionResuelvoExplorando.json";
  $archivo = json_encode(new EA($_POST['inlineRadioOptions'],getActivity(),getTasks(),getDepos(),getAllElems()));
  file_put_contents($fichero, $archivo);
}

function comprimirCarpetas($path){

  // Get real path for our folder
  $rootPath = realpath($path);
  // Initialize archive object
  $zip = new ZipArchive();
  $zip->open($path.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
  // Create recursive directory iterator
  /** @var SplFileInfo[] $files */
  $files = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($rootPath),
      RecursiveIteratorIterator::LEAVES_ONLY
  );
  foreach ($files as $name => $file)
  {
      // Skip directories (they would be added automatically)
      if (!$file->isDir())
      {
          // Get real and relative path for current file
          $filePath = $file->getRealPath();
          $relativePath = substr($filePath, strlen($rootPath) + 1);

          // Add current file to archive
          $zip->addFile($filePath, $relativePath);
      }
  }
  // Zip archive will be created only after closing object
  $zip->close();
}

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function clearUserFolder(){
  if(is_dir('utils/CodigosQR')){
    eliminarArchivos('utils/CodigosQR');
    rmdir("utils/CodigosQR/Elementos/T1");
    rmdir("utils/CodigosQR/Elementos/T2");
    rmdir("utils/CodigosQR/Elementos/T3");
    rmdir('utils/CodigosQR/Tareas');
    rmdir('utils/CodigosQR/Depositos');
    rmdir('utils/CodigosQR/Elementos');
    rmdir('utils/CodigosQR');
  }
}

function eliminarArchivos($path){
  // Get real path for our folder
  $rootPath = realpath($path);

  $files = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($rootPath),
      RecursiveIteratorIterator::LEAVES_ONLY
  );
  foreach ($files as $name => $file)
  {
      // Skip directories (they would be added automatically)
      if (!$file->isDir())
      {
          // Get real and relative path for current file
          $filePath = $file->getRealPath();
          $relativePath = substr($filePath, strlen($rootPath) + 1);

          unlink($filePath);
      }
  }
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

function generateUserFolder(){
  clearUserFolder();
  mkdir("utils/CodigosQR", 0777);
  mkdir("utils/CodigosQR/Depositos", 0777);
  mkdir("utils/CodigosQR/Tareas", 0777);
  mkdir("utils/CodigosQR/Elementos", 0777);
  mkdir("utils/CodigosQR/Elementos/T1", 0777);
  mkdir("utils/CodigosQR/Elementos/T2", 0777);
  mkdir("utils/CodigosQR/Elementos/T3", 0777);
}

function generateQR($tamano){
  $depos = getDepos();
  generateUserFolder();
  foreach ($depos as $index => $depo) {
    QRcode::jpg($depo->getCode(),'utils/CodigosQR/Depositos/'.$depo->getCode().'.jpg', QR_ECLEVEL_L, 10);
  }
  $tasks = getTasks();
  foreach ($tasks as $index => $task) {
    QRcode::jpg($task->getCode(),'utils/CodigosQR/Tareas/tarea '.($index+1).'.jpg', QR_ECLEVEL_L, 10);
  }
  define('IMAGE_WIDTH',$tamano);
  define('IMAGE_HEIGHT',$tamano);
  for ($i=1; $i <= 3; $i++) {
    $elems = getElems($i);
    foreach ($elems as $index => $elem) {
      QRcode::jpg($elem->getCode(),'utils/CodigosQR/Elementos/T'.$i.'/'.$elem->getCode().'.jpg', QR_ECLEVEL_L, $tamano);
    }
  }
}

function renameEspaciosDeUso() {
  $dir = new DirectoryIterator("utils\ResuelvoExplorando\Configuracion\Imagenes\\");
  $tasks = getTasks();
  $nombresNuevos = array("task1" => $tasks[0]->name,"task2" => $tasks[1]->name,"task3" => $tasks[2]->name);
  foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
        $name = $fileinfo->getFilename();
        $name = utf8_decode(strtr($name,$nombresNuevos));
        rename(utf8_decode("utils\ResuelvoExplorando\Configuracion\Imagenes\\".$fileinfo->getFilename()),"utils\ResuelvoExplorando\Configuracion\Imagenes\\".$name);
      }
  }
}

function eliminar_tildes($cadena){
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}

function generarPDF() {
  require_once('libs\TCPDF\tcpdf.php');
  require 'pdfGenerator.php';

  $pdf = initPdf();

  imprimirTareas($pdf);
	imprimirDepositos($pdf);

  // Close and output PDF document
  ob_clean();
  $pdf->Output(__DIR__.'/utils/CodigosQR/Codigos.pdf', 'F');
}

?>
