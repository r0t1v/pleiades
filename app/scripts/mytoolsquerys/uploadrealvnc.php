<?php
session_start();
require __DIR__.'\..\..\config.php';
include __DIR__.'\..\..\scripts\verifyauth.php';

$IdRealVNCCreate = filter_var($_POST['userrealvncid'], FILTER_SANITIZE_STRING);
$PassRealVNCCreate = filter_var($_POST['userrealvncpass'], FILTER_SANITIZE_STRING);

if(strlen($IdRealVNCCreate)>=9 and strlen($IdRealVNCCreate)<=12 and strlen($PassRealVNCCreate)>=8 and strlen($PassRealVNCCreate)<=32){
    /* Format Tools*/
    for($a=0; $a<$_SESSION['UserTools']['CountTools']; $a++){

        switch ($_SESSION['UserTools'][$a][2]) {
            case 1:
                $UserAnyDeskID = $_SESSION['UserTools'][$a][0];
                $UserAnyDeskPass = $_SESSION['UserTools'][$a][1];
                break;
            case 2:
                $UserTeamViewerID = $_SESSION['UserTools'][$a][0];
                $UserTeamViewerPass = $_SESSION['UserTools'][$a][1];
                break;
            case 3:
                $UserRealVncID = $_SESSION['UserTools'][$a][0];
                $UserRealVncPass = $_SESSION['UserTools'][$a][1];
                break;
            case 4:
                $UserPcName = $_SESSION['UserTools'][$a][0];
                $UserIP = $_SESSION['UserTools'][$a][1];
                break;
        }
    }
    /* Format Tools*/
    if($IdRealVNCCreate!=$UserRealVncID || $PassRealVNCCreate!=$UserRealVncPass){

        $QueryIfExists = "SELECT login,pass FROM usertools WHERE tipotool=3 AND id_conta='".$_SESSION['DataAccount']['id']."'";
        $QueryIfExistsExec = mysqli_query($CONNECTION_DB, $QueryIfExists);
        $QueryIfExistsRow = mysqli_num_rows($QueryIfExistsExec);

        if($QueryIfExistsRow==0){
            $QueryRegisterRealVNC = "INSERT INTO usertools(id,id_conta,tipotool,login,pass) VALUES ('','".$_SESSION['DataAccount']['id']."','3','$IdRealVNCCreate','$PassRealVNCCreate')";
            $QueryRegisterRealVNCExec = mysqli_query($CONNECTION_DB, $QueryRegisterRealVNC);

            $QueryInsertNotification = "INSERT INTO notifications(id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Cadastro em ferramentas','4','".date('Y-m-d H:i:s')."','0')";
            $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

            /* Update Tools */
            unset($_SESSION['UserTools']);
            $QueryAnydeskUser = "SELECT login,pass,tipotool FROM usertools WHERE id_conta='".$_SESSION['DataAccount']['id']."'";
            $QueryAnydeskUserExec = mysqli_query($CONNECTION_DB, $QueryAnydeskUser);

            for($k=0; $k<mysqli_num_rows($QueryAnydeskUserExec); $k++){
                $DataTools = mysqli_fetch_assoc($QueryAnydeskUserExec);
                $_SESSION['UserTools'][$k][] = $DataTools['login'];
                $_SESSION['UserTools'][$k][] = $DataTools['pass'];
                $_SESSION['UserTools'][$k][] = $DataTools['tipotool'];
            }
            $_SESSION['UserTools']['CountTools'] = mysqli_num_rows($QueryAnydeskUserExec);
            /* Update Tools */

            /* Update Notifications */
            unset($_SESSION['DataNotifications']);
            $QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['DataAccount']['id']."' ORDER BY data_notification DESC";
            $QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
            for($j=0; $j<mysqli_num_rows($QueryNotificationsExec); $j++){
                $DataTools = mysqli_fetch_assoc($QueryNotificationsExec);
                $_SESSION['DataNotifications'][$j][] = $DataTools['descricao'];
                $_SESSION['DataNotifications'][$j][] = $DataTools['tipo_notification'];
            }
            $_SESSION['DataNotifications']['CountNotifications'] = mysqli_num_rows($QueryNotificationsExec);
            /* Update Notifications */

            $_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram salvas com sucesso no banco de dados!</div>';
            header("Location: ..\..\pages\corporate_page.php");
            exit;

        }else{
            $QueryRegisterRealVNC = "UPDATE usertools SET login='$IdRealVNCCreate',pass='$PassRealVNCCreate' WHERE tipotool=3 AND id_conta='".$_SESSION['DataAccount']['id']."'";
            $QueryRegisterRealVNCExec = mysqli_query($CONNECTION_DB, $QueryRegisterRealVNC);

            $QueryInsertNotification = "INSERT INTO notifications (id_conta,descricao,tipo_notification,data_notification,visualizado) VALUES ('".$_SESSION['DataAccount']['id']."','Mudança em ferramentas','4','".date('Y-m-d H:i:s')."','0')";
            $QueryInsertNotificationExec = mysqli_query($CONNECTION_DB, $QueryInsertNotification);

            /* Update Tools */
            unset($_SESSION['UserTools']);
            $QueryAnydeskUser = "SELECT login,pass,tipotool FROM usertools WHERE id_conta='".$_SESSION['DataAccount']['id']."'";
            $QueryAnydeskUserExec = mysqli_query($CONNECTION_DB, $QueryAnydeskUser);

            for($k=0; $k<mysqli_num_rows($QueryAnydeskUserExec); $k++){
                $DataTools = mysqli_fetch_assoc($QueryAnydeskUserExec);
                $_SESSION['UserTools'][$k][] = $DataTools['login'];
                $_SESSION['UserTools'][$k][] = $DataTools['pass'];
                $_SESSION['UserTools'][$k][] = $DataTools['tipotool'];
            }
            $_SESSION['UserTools']['CountTools'] = mysqli_num_rows($QueryAnydeskUserExec);
            /* Update Tools */

            /* Update Notifications */
            unset($_SESSION['DataNotifications']);
            $QueryNotifications = "SELECT descricao,tipo_notification FROM notifications WHERE visualizado='0' AND id_conta='".$_SESSION['DataAccount']['id']."' ORDER BY data_notification DESC";
            $QueryNotificationsExec = mysqli_query($CONNECTION_DB, $QueryNotifications);
            for($j=0; $j<mysqli_num_rows($QueryNotificationsExec); $j++){
                $DataTools = mysqli_fetch_assoc($QueryNotificationsExec);
                $_SESSION['DataNotifications'][$j][] = $DataTools['descricao'];
                $_SESSION['DataNotifications'][$j][] = $DataTools['tipo_notification'];
            }
            $_SESSION['DataNotifications']['CountNotifications'] = mysqli_num_rows($QueryNotificationsExec);
            /* Update Notifications */

            $_SESSION['Msg'] = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill"></i> Informações foram salvas com sucesso no banco de dados!</div>';
            header("Location: ..\..\pages\corporate_page.php");
            exit;
        }

    }else{
        $_SESSION['Msg'] = '<div class="alert alert-info" role="alert"><i class="bi bi-info-circle-fill"></i> Informações não podem ser as mesmas ao salvar!</div>';
        header("Location: ..\..\pages\corporate_page.php");
        exit;
    }

}else{
    $_SESSION['Msg'] = '<div class="alert alert-danger" role="alert"><i class="bi bi-x-circle-fill"></i> Não foi possível salvar as informações!</div>';
    header("Location: ..\..\pages\corporate_page.php");
	exit;
}

mysqli_close($CONNECTION_DB);