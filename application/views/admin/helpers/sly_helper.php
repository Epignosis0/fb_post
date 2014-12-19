<?php
function print_flex($data){
	echo ('<pre>');
	print_r ($data);
	echo ('</pre>');
}


class NotificationHepler
{
    static public function distribution(){
            $ci = & get_instance();
            $ci->load->library('android_notification');
            $ci->load->model('subscribe');
            $limit = $ci->config->item('subscribers.limit.in.one.pack');
            $androidNotification = new Android_notification();
            $message = $_POST['message'];
            
            
		
            //Android Notifications
            $countTokens = $ci->subscribe->getSubscribersTokensCount('', 'Android');
            $androidNotification->openConnect();
            for($i = 0; $i<ceil($countTokens/$limit); $i++)
            {
                $tokens = $ci->subscribe->getSubscribersTokens('', 'Android', $i*$limit, $limit);
                $androidNotification->setRegistartionID($tokens)
                                    ->setMessageText($message)
                                    ->setData(array('data.application' => 'testApp',
						    'data.type' =>'Cool'))
                                    ->send();
            }
            $androidNotification->closeConnect();
            
            
            
    }
    
}
