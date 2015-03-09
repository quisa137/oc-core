<?php
    $secureboxInstallPath = '/home/sgcom/securebox/apps/';
    $installPath = $_SERVER['DOCUMENT_ROOT'];
    if(!empty($_POST)) {
        $installPackages = $_POST['installpackages'];
        shell_exec('whoami');
        $installed = array();
        if(!empty($installPackages)) {
            $installPackages = explode(',',$installPackages);
        }else{
            $installPackages = array();
        }
        
        foreach ($installPackages as $shellscript) {
            // $output = shell_exec('/home/sgcom/securebox/apps/sbotp.sh');
            $output = shell_exec(
                $secureboxInstallPath.$shellscript.'.sh '.$installPath
            );
            // $output = `/home/sgcom/securebox/apps/sbotp.sh`;
            if(trim($output)==='Install Complete') {
                $installed[$shellscript] = 'Success';
            }else{
                $installed[$shellscript] = $output;
            }
        }
    }
    header('Content-type: application/json; charset=UTF-8');
    
    echo json_encode($installed);
?>
