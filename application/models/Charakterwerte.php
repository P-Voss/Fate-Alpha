<?php

/**
 * Description of Application_Model_Charakterwerte
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Charakterwerte {
    
    protected $staerke;
    protected $agilitaet;
    protected $ausdauer;
    protected $disziplin;
    protected $kontrolle;
    protected $uebung;
    protected $fp;
    protected $startpunkte;
    
    public function getStaerke() {
        return $this->staerke;
    }

    public function getAgilitaet() {
        return $this->agilitaet;
    }

    public function getAusdauer() {
        return $this->ausdauer;
    }

    public function getDisziplin() {
        return $this->disziplin;
    }

    public function getKontrolle() {
        return $this->kontrolle;
    }

    public function getUebung() {
        return $this->uebung;
    }

    public function getFp() {
        return $this->fp;
    }

    public function getStartpunkte() {
        return $this->startpunkte;
    }

    public function setStaerke($staerke) {
        $this->staerke = $staerke;
    }

    public function setAgilitaet($agilitaet) {
        $this->agilitaet = $agilitaet;
    }

    public function setAusdauer($ausdauer) {
        $this->ausdauer = $ausdauer;
    }

    public function setDisziplin($disziplin) {
        $this->disziplin = $disziplin;
    }

    public function setKontrolle($kontrolle) {
        $this->kontrolle = $kontrolle;
    }

    public function setUebung($uebung) {
        $this->uebung = $uebung;
    }

    public function setFp($fp) {
        $this->fp = $fp;
    }

    public function setStartpunkte($startpunkte) {
        $this->startpunkte = $startpunkte;
    }
    
    public function getCategory($value) {
        switch (true) {
            case $value > 660:
                $category = "A+";
                break;
            case $value > 600:
                $category = "A";
                break;
            case $value > 540:
                $category = "A-";
                break;
            case $value > 480:
                $category = "B+";
                break;
            case $value > 430:
                $category = "B";
                break;
            case $value > 380:
                $category = "B-";
                break;
            case $value > 330:
                $category = "C+";
                break;
            case $value > 290:
                $category = "C";
                break;
            case $value > 250:
                $category = "C-";
                break;
            case $value > 210:
                $category = "D+";
                break;
            case $value > 180:
                $category = "D";
                break;
            case $value > 150:
                $category = "D-";
                break;
            case $value > 120:
                $category = "E+";
                break;
            case $value > 80:
                $category = "E";
                break;
            case $value > 40:
                $category = "E-";
                break;
            case $value > 0:
                $category = "F+";
                break;
            case $value == 0:
                $category = "F";
                break;
            default:
                $category = "F-";
                break;
        }
        return $category;
    }
    
}
