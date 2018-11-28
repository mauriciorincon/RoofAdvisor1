<?php

class BuildPhar
{
  private $_sourceDirectory = null;
  private $_stubFile        = null;
  private $_outputDirectory = null;
  private $_pharFileName    = null;

  /**
   * @param $_sourceDirectory       // This is the directory where your project is stored.
   * @param $stubFile               // Name the entry point for your phar file. This file have to be within the source
   *                                   directory. 
   * @param null $_outputDirectory  // Directory where the phar file will be placed.
   * @param string $pharFileName    // Name of your final *.phar file.
   */
  public function __construct($_sourceDirectory, $stubFile, $_outputDirectory = null, $pharFileName = 'myPhar.phar') {

    if (is_array($_sourceDirectory)) $this->_sourceDirectory = $_sourceDirectory;
    else $this->_sourceDirectory = array($_sourceDirectory);

    $this->_stubFile = null;
    foreach ($this->_sourceDirectory as $s) {
      if ((file_exists($s) === false) || (is_dir($s) === false)) {
        throw new Exception('No valid ($s) source directory given.');
      }

      if (file_exists($s.'/'.$stubFile) === true and is_null($this->_stubFile)) {
        $this->_stubFile = $stubFile;
      }
    }

    if (!$this->_stubFile) {
      throw new Exception('Your given stub file doesn\'t exists.');
    }


    if(empty($pharFileName) === true) {
      throw new Exception('Your given output name for your phar-file is empty.');
    }
    $this->_pharFileName = $pharFileName;

    if ((empty($_outputDirectory) === true) || (file_exists($_outputDirectory) === false) || (is_dir($_outputDirectory) === false)) {

      if ($_outputDirectory !== null) {
        trigger_error ( 'Your output directory is invalid. We set the fallback to: "'.dirname(__FILE__).'".', E_USER_WARNING);
      }

      $this->_outputDirectory = dirname(__FILE__);
    } else {
      $this->_outputDirectory = $_outputDirectory;
    }

    $this->prepareBuildDirectory();
    $this->buildPhar();
  }

  private function prepareBuildDirectory() {
    if (preg_match('/.phar$/', $this->_pharFileName) == FALSE) {
      $this->_pharFileName .= '.phar';
    }

    if (file_exists($this->_pharFileName) === true) {
      unlink($this->_pharFileName);
    }
  }

  private function buildPhar() {
    echo "output ".$this->_outputDirectory;
    $phar = new Phar($this->_outputDirectory.'/'.$this->_pharFileName);
#    $phar->buildFromDirectory($this->_sourceDirectory,'/.php$/');
    $exclude = '/^(?!(.*\/conf.php$))/i';
    foreach ($this->_sourceDirectory as $s) {
      $phar->buildFromDirectory($s,$exclude);
    }
    $phar->setDefaultStub($this->_stubFile);
  }
}
//END Class

//Example Usage:
$builder = new BuildPhar(
  [dirname(__FILE__).'/src',dirname(__FILE__).'/vendor'],
  'index.php',
  dirname(__FILE__).'/build',
  'roofservicenow-web.phar'
);
