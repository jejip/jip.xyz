<?php
    if($_POST){
        // response hash
        $response = array('type'=>'', 'message'=>'');
 
        try{
            // do some sort of data validations, very simple example below
            $required_fields = array('email', 'message');
            foreach($required_fields as $field){
                if(empty($_POST[$field])){
                    throw new Exception('Required field "'.ucfirst($field).'" missing input.');
                }
            }
 
            // ok, field validations are ok
            // now add to data to DB, Send Email, ect.
 
            // let's assume everything is ok, setup successful response
            $response['type'] = 'success';
            $response['message'] = 'Thank-You for submitting the form!';
        }catch(Exception $e){
            $response['type'] = 'error';
            $response['message'] = $e->getMessage();
        }
        // now we are ready to turn this hash into JSON
        print json_encode($response);
        exit;
    }
?>