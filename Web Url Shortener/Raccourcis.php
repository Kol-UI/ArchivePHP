<?php

class GenerationURL {

    public function enregistrerUrl($long_url, $key)
    {
        $str = implode("|", [$long_url, $key])."\n";
        $fd  = fopen('Stockage-url.txt', 'a');
        $out = print_r($str, true);
        fwrite($fd, $out);
    }
    public function lecture()
    {
        $file = file('Stockage-url.txt',FILE_SKIP_EMPTY_LINES);
        foreach($file as $row)
        {
            $arv[] = explode("|", $row);
        }
        return $arv;
    }
    public function checkTailleUrl($long_url)
    {
        $db_list = $this->lecture();
        for ($x = 0; $x < count($db_list); $x++)
        {
            if($db_list[$x][0] === $long_url)
            {
                return $db_list[$x][1];
            }
        }
        return $this->creationId($long_url);
    }

    public function creationId($long_url)
    {
        $randKeys = 'abcdefghijklmonpqrstuvwxyz';
        do{
            for ($x = 0; $x < 5; $x++)
            {
                $ranNum = mt_rand(0, strlen($randKeys)-1);
                $str = substr($randKeys, $ranNum, 1);
            }
            $doesKeyExists = $this->checkValiditeId($str);
            if($doesKeyExists === 'T')
            {
                $status = 'CONTINUE';
            }else
            {
                $status = 'STOP';
            }
        }while($status === 'CONTINUE');
        $this->enregistrerUrl($long_url, $str);
        return $str;
    }

    public function checkValiditeId($key)
    {
        $db_list = $this->lecture();
        for ($x = 0; $x < count($db_list); $x++)
        {
            if($db_list[$x][1] === $key)
            {
                return 'VRAI';
            }
        }
        return 'FAUX';
    }
}

if(!empty($_POST['url']))
{
    $url = filter_var(trim($_POST['url']), FILTER_SANITIZE_URL);
    if(filter_var($url, FILTER_VALIDATE_URL) === FALSE )
    {
        echo json_encode(['status'=>0]);
        return false;
    }
    $Short = new GenerationURL();
    $keyId = $Short->checkTailleUrl($url);
    $file = file_get_contents('Stockage-url.txt', FILE_USE_INCLUDE_PATH);
    echo $file;
}else
{
    echo json_encode(['status'=>0]);
    echo "test";
}
