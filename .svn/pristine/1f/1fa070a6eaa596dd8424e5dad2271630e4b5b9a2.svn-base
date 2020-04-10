<?php
/**
 * User: Vo Duy Tuan
 */
class Controller_Task_Abc extends Controller_Task_Base
{
    public function indexAction()
    {
        die('a');
        exit();
        $pid = (int)$_GET['id'];
        $from = (string)$_GET['from'];
        $editsection = (string)$_GET['editsection'];

        if($from == 'add')
        {
            //Insert Notification
            $myNotificationProductAdd = new Core_Backend_Notification_ProductAdd();
            $myNotificationProductAdd->pid = $pid;
            if(is_array($this->registry->setting['notification']['productchangereceiver']))
            {
                $notificationReceivers = $this->registry->setting['notification']['productchangereceiver'];
                if($myNotificationProductAdd->addDataToMany($notificationReceivers))
                {
                    //increase notification count for receivers
                    Core_User::notificationIncrease('notification', $notificationReceivers);

                    echo 'sent ok';
                }
            }
        }
        elseif($from == 'edit')
        {
            //Insert Notification
            $myNotificationProductEdit = new Core_Backend_Notification_ProductEdit();
            $myNotificationProductEdit->pid = $pid;
            $myNotificationProductEdit->editsection = $editsection;
            if(is_array($this->registry->setting['notification']['productchangereceiver']))
            {
                $notificationReceivers = $this->registry->setting['notification']['productchangereceiver'];
                if($myNotificationProductEdit->addDataToMany($notificationReceivers))
                {
                    //increase notification count for receivers
                    Core_User::notificationIncrease('notification', $notificationReceivers);

                    echo 'sent ok';
                }
            }
        }//end check from action
        
    }
    
}