<?php

/**
* 
*/
class Uploader
{

  function __construct($debug=False)
  {
    $this->debug = $debug;
  }

  private $extentions = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif');
  public $dir = "upload";
  public $filename = None;
  
  public function set_extentions($extentions) {
    $this->extentions = $extentions;
  }

  public function set_directory($dir) {
    $this->dir = $dir;
    if(!file_exists($this->dir)) {
      mkdir($this->dir,0777,true);
    }
  }

  public function set_filename($filename)
  {
    $this->filename = $filename;
  }

  public function show_file($path=None) {
    if($path==None) $path=$this->dir.'/'.$_FILES['upload']['name'];
    echo '<p><img src="./'.$path.'" /></p>';
  }


  public function upload()
  {
    // 1.업로드 상태여부를 체크
    if (isset($_POST['upload_check'])) {

      // 2.업로드된 파일의 존재여부 및 전송상태 확인
      if (isset($_FILES['upload']) && !$_FILES['upload']['error']) {

        // 3-1.허용할 이미지 종류를 배열로 저장
        $this->extentions = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif');

        // 3-2.extentions 배열내에 $_FILES['upload']['type']에 해당되는 타입(문자열) 있는지 체크
        if (in_array($_FILES['upload']['type'], $this->extentions)) {
        // if ($_FILES['upload']['type']==$_POST['type']) {
        
          // 4.허용하는 이미지파일이라면 지정된 위치로 이동
          if ($this->filename==None) $this->filename = $_FILES['upload']['name'];
          if (move_uploaded_file ($_FILES['upload']['tmp_name'], "./".$this->dir."/".$this->filename)) {

            // 5.업로드된 이미지 파일을 출력

          } //if , move_uploaded_file
          
        } else { // 3-3.허용된 이미지 타입이 아닌경우
          if($this->debug)
          echo '<p>JPEG 또는 PNG 이미지만 업로드 가능합니다.</p>';
          return False;
        }//if , inarray

      } //if , isset
      

      // 6.에러가 존재하는지 체크
      if ($_FILES['upload']['error'] > 0) {
        if ($this->debug) {
        echo '<p>파일 업로드 실패 이유: <strong>';
      
        // 실패 내용을 출력
        switch ($_FILES['upload']['error']) {
          case 1:
            echo 'php.ini 파일의 upload_max_filesize 설정값을 초과함(업로드 최대용량 초과)';
            break;
          case 2:
            echo 'Form에서 설정된 MAX_FILE_SIZE 설정값을 초과함(업로드 최대용량 초과)';
            break;
          case 3:
            echo '파일 일부만 업로드 됨';
            break;
          case 4:
            echo '업로드된 파일이 없음';
            break;
          case 6:
            echo '사용가능한 임시폴더가 없음';
            break;
          case 7:
            echo '디스크에 저장할수 없음';
            break;
          case 8:
            echo '파일 업로드가 중지됨';
            break;
          default:
            echo '시스템 오류가 발생';
            break;
        } // switch
        
        echo '</strong></p>';
        }

        return False;
      } // if
      
      // 7.임시파일이 존재하는 경우 삭제
      if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
        unlink ($_FILES['upload']['tmp_name']);
      }
      return True;
    } else {
      return False;
    }
  }

}



?>

