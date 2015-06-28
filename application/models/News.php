<?php

/**
 * Description of News
 *
 * @author Vosser
 */
class Application_Model_News {
    
    protected $id;
    protected $titel;
    protected $nachricht;
    protected $verfasser;
    protected $verfasserName;
    protected $datum;
    protected $editor;
    protected $editorName;
    protected $editdatum;
    
    public function getId() {
        return $this->id;
    }

    public function getTitel() {
        return $this->titel;
    }

    public function getNachricht() {
        return $this->nachricht;
    }

    public function getVerfasser() {
        return $this->verfasser;
    }

    public function getDatum() {
        $date = new DateTime($this->datum);
        return $date->format('d.m.Y H:i');
    }

    public function getEditor() {
        return $this->editor;
    }

    public function getEditdatum() {
        $date = new DateTime($this->editdatum);
        return $date->format('d.m.Y H:i');
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitel($titel) {
        $this->titel = $titel;
    }

    public function setNachricht($nachricht) {
        $this->nachricht = $nachricht;
    }

    public function setVerfasser($verfasser) {
        $this->verfasser = $verfasser;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setEditor($editor) {
        $this->editor = $editor;
    }

    public function setEditdatum($editdatum) {
        $this->editdatum = $editdatum;
    }

    public function getVerfasserName() {
        return $this->verfasserName;
    }

    public function setVerfasserName($verfasserName) {
        $this->verfasserName = $verfasserName;
    }
    
    public function getEditorName() {
        return $this->editorName;
    }

    public function setEditorName($editorName) {
        $this->editorName = $editorName;
    }


    
}
