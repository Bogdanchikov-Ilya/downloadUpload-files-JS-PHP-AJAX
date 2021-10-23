<?php
function getFiles() {
    $res = [];
    $files = array_diff( scandir( 'files'), array('..', '.'));

    foreach ($files as $filename) {
        $res[] = ["filename" => $filename];
    }
    echo json_encode($res);
}

function downloadFile($filename) {
  	$curDir = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__) . '/files';
    $file = $curDir . '/' . $filename;
    $file = 'files/' . $filename;
    if (file_exists($file)) {
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

function uploadFile(){
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileName = str_replace(['+', '-', '[', ']', '$', '&', '_', '='], '', $fileName); // удаляем символы из названия чтобы они не повлияли на скачивание

    $uploadFileDir = 'files/';
    $dest_path = $uploadFileDir . $fileName;
    if(!file_exists('files/' . $fileName)){
        echo 'файл не сущетсвует';
        if(move_uploaded_file($fileTmpPath, $dest_path)){
            http_response_code(200);
            echo $message ='Файл успешно загружен!';
            die();
        }
        else{
            http_response_code(500);
            echo $message = 'Ошибка загрузки файла';
            die();
        }
    } else {
        http_response_code(409);
        echo '';
    }
}
?>