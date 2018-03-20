<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addons extends CI_Model {
    

    public function __construct(){
        parent::__construct();
    }
    function units($x){
        $a = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
        return $a[$x];
    }
    function teens($x){
        $teens  = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
        return $teens[$x];
    }
    function tens($x){
        $tens   = array(2 => 'twenty', 'thirty', 'fourty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
        return $tens[$x];
    }
    function suffix($x){
        $suffix = array('thousand', 'million', 'billion', 'trillion', 'quadrillion');
        return $suffix[$x];
    }
    function create_log($user, $jenis, $ket){
    	$data['user'] 		= $user;
    	$data['jenis']		= $jenis;
    	$data['keterangan']	= $ket;
    	$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
    	$this->db->insert('sys_log',$data);
    }
    function nologin(){
        $user = $this->session->userdata('user_id');
        if($user == NULL || $user == 0){
            redirect(base_url('user/login?callback=http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']));
        }
    }
    function islogin(){
        $user = $this->session->userdata('user_id');
        if($user != NULL || $user != 0){
            redirect(base_url());
        }
    }


    private function ToString($int)
    {
        // Check for purely numeric chars
        if (!preg_match('#^[\d.]+$#', $int)) {
            throw new Exception('Invalid characters in input');
        }

        // Handle decimals
        if (strpos($int, '.') !== false) {
            $decimal = substr($int, strpos($int, '.') + 1);
            $int     = substr($int, 0, strpos($int, '.'));
        }

        // Lose insignificant zeros
        $int = ltrim($int, '0');
        
        // Check for valid number
        if ($int == '') {
            $int = '0';
        }
        

        // Lose the negative, don't use abs() so as to allow large numbers
        if ($negative = ($int < 0)) {
            $int = substr($int, 1);
        }

        // Number too big?
        if (strlen($int) > 18) {
            throw new Exception('Out of range');
        }

        // Keep original number
        $orig = $int;

        /**
        * Main number deciphering bit thing
        */
        switch (strlen($int)) {
            
            // Single digit number
            case '1':
                $text = $this->units($int);
                break;


            // Two digit number
            case '2':
                if ($int{0} == '1') {
                    $text = $this->teens($int{1});
                
                } else if ($int{1} == '0') {
                    $text = $this->tens($int{0});
                
                } else {
                    $text = $this->tens($int{0}) . '-' . $this->units($int{1});
                }
                break;


            // Three digit number
            case '3':
                if ($int % 100 == 0) {
                    $text = $this->units($int{0}) . ' hundred';
                } else {
                    $text = $this->units($int{0}) . ' hundred and ' . $this->GetText(substr($int, 1));
                }
                break;


            // Anything else
            default:
                $pieces      = array();
                $suffixIndex = 0;

                // Handle the last three digits
                $num = substr($int, -3);
                if ($num > 0) {
                    $pieces[] = $this->GetText($num);
                }
                $int = substr($int, 0, -3);

                // Now handle the thousands/millions etc
                while (strlen($int) > 3) {
                    $num   = substr($int, -3);
                    
                    if ($num > 0) {
                        $pieces[] = $this->GetText($num) . ' ' . $this->suffix($suffixIndex);
                    }
                    $int = substr($int, 0, -3);
                    $suffixIndex++;
                }

                $pieces[] = $this->GetText(substr($int, -3)) . ' ' . $this->suffix($suffixIndex);

                /**
                * Figure out whether we need to add "and" in there somewhere
                */
                $pieces = array_reverse($pieces);

                if (count($pieces) > 1 AND strpos($pieces[count($pieces) - 1], ' and ') === false) {
                    $pieces[] = $pieces[count($pieces) - 1];
                    $pieces[count($pieces) - 2] = 'and';
                }

                // Create the text
                $text = implode(' ', $pieces);
                
                // Negative number?
                if ($negative) {
                    $text = 'minus ' . $text;
                }
                break;
        }
        
        /**
        * Handle any decimal part
        */
        if (!empty($decimal)) {
            $pieces  = array();
            $decimal = preg_replace('#[^0-9]#', '', $decimal);
            
            for ($i=0, $len=strlen($decimal); $i<$len; ++$i) {
                $pieces[] = $this->units($decimal{$i});
            }
            
            $text .= ' point ' . implode(' ', $pieces);
        }


        return $text;
    }
    
    public function GetText($int)
    {
        return $this->ToString($int);
    }
    public function Get()
    {
        $int = mt_rand();
        return array($int, $this->ToString($int));
    }
    
    public function GetCurrency($int, $major = 'pound', $minor = 'pence')
    {
        if (strpos($int, '.') !== false) {
            $left  = substr($int, 0, strpos($int, '.'));
            $right = substr($int, strpos($int, '.') + 1);
            
            // Plural $major ?
            if ((int)abs($left) != 1) {
                $major .= 's';
            }

            $text  = $this->GetText($left) . " $major and " . $this->GetText($right) . " $minor";

        } else {
            $text = $this->GetText($int) . " $major";
        }
        
        return $text;
    }
}