<?php

class Transmission{

    const BASECMD = 'transmission-remote ';
    const AUTHSTR = "-n 'transmission:transmission' ";
    const NOINSTALLERR = 'Cannot access Transmission. Please verify your installation.';
    const VERSIONPATT = '/transmission-remote\s[0-9]{1}.[0-9]{1,2}/';
    const SUCCESSPATT = '/success/';

    public function __construct()
    {
        if(!$this->_testInstall()){
            throw new \Exception(self::NOINSTALLERR);
        }
    }
    protected function _testInstall(){
        $cmd = self::BASECMD . '-V 2>&1';
        $output = shell_exec($cmd);
        if(preg_match(self::VERSIONPATT,$output)){
            return true;
        }
        return false;
    }
    public function addTorrent($path){
        $cmd = self::BASECMD . self::AUTHSTR . "-a " . $path;
        $output = shell_exec($cmd);
        if(!preg_match(self::SUCCESSPATT,$output)){
            throw new Exception($output);
        }
        return $this;
    }
}