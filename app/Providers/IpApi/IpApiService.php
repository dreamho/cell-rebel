<?php
namespace Ranking\Providers\IpApi;
class IpApiService
{
    private function buildURL ($ip) {
        //return 'https://ipapi.co/'.$ip.'/json';
		return 'http://ip-api.com/json/'.$ip;
    }
    private function IPIsPrivate ($ip) {
        $pri_addrs = array (
                          '10.0.0.0|10.255.255.255', // single class A network
                          '172.16.0.0|172.31.255.255', // 16 contiguous class B network
                          '192.168.0.0|192.168.255.255', // 256 contiguous class C network
                          '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
                          '127.0.0.0|127.255.255.255' // localhost
                         );
    
        $long_ip = ip2long ($ip);
        if ($long_ip != -1) {
    
            foreach ($pri_addrs AS $pri_addr) {
                list ($start, $end) = explode('|', $pri_addr);
    
                 // IF IS PRIVATE
                 if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) {
                     return true;
                 }
            }
        }
    
        return false;
    }
    public function get($ip=false){
        if(empty($ip)){
            return array();
        }
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return array();
        }
        if($this->IPIsPrivate($ip)){
            return array();
        }
        $data = array();
        try{
            $data = $this->locate($ip);
        } catch(exception $e){
            $data = array();
        }
        if(empty($data)||!is_array($data)){
            $data = array();
        }
        return $data;
        
    }
    private function locate($_ipAddress=false){
        if(empty($_ipAddress)){
            return false;
        }
        $url = $this->buildURL($_ipAddress); 
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	    
        $data = curl_exec($curl);
        curl_close($curl);
        
       
        $result = json_decode ($data, true);
        
        if ($result === null || !isset($result['status'])) {
            return null;
        }
        
        if ($result['status'] === 'fail') {
            return null;
        }
        
        unset ($result['status']);
        return $result;
     }
}
?>