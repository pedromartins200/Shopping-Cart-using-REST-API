<?php

class tools
{
    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function _debug($v)
    {

        if (is_array($v) || is_object($v)) {
            echo "<pre>";
            print_r($v);
            echo "</pre>";
        } else {
            echo "<pre>" . $v . "</pre>";
        }
    }


    /**
     * Pega num objeto vindo do juniper em formato xml, e devolve os seus atributos
     * Estes atributos estao identificados por '@attributes'
     *
     * @param $x - objeto a processar
     * @return array - array processado
     */
    public function attr($x)
    {
        $array = array();
        if (array_key_exists('@attributes', $x)) {
            foreach ($x['@attributes'] as $k => $v) {
                $array[$k] = $v;
            }
        } else {
            echo "error";
            $this->_debug($x);
        }
        return $array;
    }


    /**
     * Obtem o Ip do cliente atual.
     * Explicacao do codigo
     * https://www.codexworld.com/how-to/get-user-ip-address-php/
     * @return mixed - IP do current User/client
     */
    public function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    /**
     * @param int $length - tamanho da string
     * @return string - retorna uma string aleatoria
     *
     * usado para gerar random password
     */
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Subtraçao de duas datas.
     * @param $date1
     * @param $date2
     * @return float
     */
    function subtractTwoDates($date1, $date2)
    {
        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        return $days;
    }

    /**
     * Transforma um objeto xml em array.
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    function xml2array($xmlObject, $out = array())
    {
        foreach ((array)$xmlObject as $index => $node) {
            $out[$index] = (is_object($node)) ? xml2array($node) : $node;
        }

        return $out;
    }




    function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function encoded($string)
    {
        $gz = gzcompress(serialize($string), 9);

        if ($gz === false) {
            mail('webmaster@teste.com', 'encoded', current_url() . ' ' . $string,
                'From: info@teste.com');
        }
        return @strtr(base64_encode(addslashes($gz)), '+/=', '-_,');
    }

    public function decoded($encoded)
    {

        $gz = gzuncompress(stripslashes(base64_decode(strtr($encoded, '-_,', '+/='))));
        if ($gz === false) {
            if ($_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)') {
                mail('webmaster@teste.com', 'decoded',
                    current_url() . ' ' . $encoded . ' ' . var_export($_SERVER, true) . ' ' . date('Y-m-d H:i:s'),
                    'From: info@teste.com');
            }
        }
        return @unserialize($gz);
    }

    function time2string($time) {
        $d = floor($time/86400);
        $_d = ($d < 10 ? '0' : '').$d;

        $h = floor(($time-$d*86400)/3600);
        $_h = ($h < 10 ? '0' : '').$h;

        $m = floor(($time-($d*86400+$h*3600))/60);
        $_m = ($m < 10 ? '0' : '').$m;

        $s = $time-($d*86400+$h*3600+$m*60);
        $_s = ($s < 10 ? '0' : '').$s;

        $time_str = $_d.':'.$_h.':'.$_m.':'.$_s;

        return array(
            'd' => $d,
            'h' => $h,
            'm' => $m,
            's' => $s
        );
    }

    /**
     * Verifica se este url contem uma imagem/ficheiro valido
     * @param $url
     * @return bool
     */
    function checkRemoteFile($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $retCode;
    }

    function removeChar($s, $c)
    {
        $n = strlen($s);
        $count = 0;
        for ($i = $j = 0; $i < $n; $i++)
        {
            if ($s[$i] != $c)
                $s[$j++] = $s[$i];
            else
                $count++;
        }
        while($count--)
        {
            $s[$j++] = NULL;
        }
        echo $s;
    }

    /**
     * Determina se é mobile device
     * @return false|int
     */
    public function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }



    /**
     * Determina se um NIF portugues é valido tendo em conta as regras.
     * Adicionado o digito 3 (nova lei de 2019)
     * @param $nif
     * @param bool $ignoreFirst
     * @return bool
     */
    public function validaNIF($nif, $ignoreFirst=true) {
        //Limpamos eventuais espaços a mais
        $nif=trim($nif);
        //Verificamos se é numérico e tem comprimento 9
        if (!is_numeric($nif) || strlen($nif)!=9) {
            return false;
        } else {
            $nifSplit=str_split($nif);
            //O primeiro digíto tem de ser 1, 2, 3, 5, 6, 8 ou 9
            //Ou não, se optarmos por ignorar esta "regra"
            if (
                in_array($nifSplit[0], array(1, 2, 3, 5, 6, 8, 9))
                ||
                $ignoreFirst
            ) {
                //Calculamos o dígito de controlo
                $checkDigit=0;
                for($i=0; $i<8; $i++) {
                    $checkDigit+=$nifSplit[$i]*(10-$i-1);
                }
                $checkDigit=11-($checkDigit % 11);
                //Se der 10 então o dígito de controlo tem de ser 0
                if($checkDigit>=10) $checkDigit=0;
                //Comparamos com o último dígito
                if ($checkDigit==$nifSplit[8]) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function formatURLName($str) {
        $str = strtolower(str_replace(' ', '-', $str));
        $str = strtolower(str_replace(',', '', $str));
        $str = strtolower(str_replace('&', '', $str));
        $str = strtolower(str_replace('--', '-', $str));
        $str = strtolower(str_replace('---', '-', $str));
        $str = str_replace('/', '-', $this->stripAccents($str, true));
        return $str;
    }

    public function stripAccents($stripAccents, $lower = FALSE){

        $normalizeChars = array(
            'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
            'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
            'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
            'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
            'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
            'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
            'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',

            ' '=>'-', '.'=>'', "'"=>'', "'"=>''
        );

        $str = strtr($stripAccents, $normalizeChars);

        if ($lower) {
            $str = strtolower($str);
        }

        return $str;
    }

}