<?php

/**
 * Description of OrteMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_OrteMapper {
    
    private $orteArray = array(
        'Bahnhof' => array(
            'Name' => 'Bahnhof',
            'img' => 'Bahnhof',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Bruecke' => array(
            'Name' => 'Brücke',
            'img' => 'Bruecke',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Promenade' => array(
            'Name' => 'Promenade',
            'img' => 'Promenade',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Kirche' => array(
            'Name' => 'Kirche',
            'img' => 'Kirche',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Tohsaka' => array(
            'Name' => 'Tohsaka',
            'img' => 'Tohsaka',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Matou' => array(
            'Name' => 'Matou',
            'img' => 'Matou',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Tempel' => array(
            'Name' => 'Tempel',
            'img' => 'Tempel',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Kirche' => array(
            'Name' => 'Kirche',
            'img' => 'Kirche',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Geisterhaus' => array(
            'Name' => 'Geisterhaus',
            'img' => 'Geisterhaus',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Hafen' => array(
            'Name' => 'Hafen',
            'img' => 'Hafen',
            'Beschreibung' => 'Der Hafen ist eine der heruntergekommenderen Gegenden von Shinto und verhältnismäßig klein, 
                                so dass sich hier nur ein paar Dutzend aneinandergereihte Lagerhallen und Bars vorfinden. 
                                Der Teil des Hafens an welchem Passagiere aus dem Ausland empfangen werden, besteht 
                                hauptsächlich aus einer Straße die aus dem Hafengebiet heraus in Shinto hinein führt.'
        ),
        'Shopping' => array(
            'Name' => 'Shopping',
            'img' => 'Shopping',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
        'Schule' => array(
            'Name' => 'Schule',
            'img' => 'Schule',
            'Beschreibung' => 'Befindet sich im Osten von Kurokizaka und ist ein sehr kleiner Bahnhof der nur Warengüter transportiert.'
        ),
    );
    private $stadtteilArray = array(
        'City' => array(
            'Name' => 'City',
            'img' => 'City',
            'Beschreibung' => 'Mit City ist das Zentrum Shintos gemeint, in welchem sämtliche Bäume und Gärten von Hochhäusern und Konzerngebäuden abgelöst worden sind. 
                                Es gibt hier die größte Auswahl an Einkaufsmöglichkeiten und ein wachsendes Angebot von Arbeit.'
        ),
        'Kizaka' => array(
            'Name' => 'Kizaka',
            'img' => 'Kizaka',
            'Beschreibung' => 'Kizaka ist das Gebiet welches sich ausserhalb von Shinto-Innen befindet. Hier gibt es viele Grünanlagen und an vielen Stellen ähnelt es Miyamachou.'
        ),
        'Kurokizaka' => array(
            'Name' => 'Kurokizaka',
            'img' => 'Kurokizaka',
            'Beschreibung' => 'Mit Kurokizaka ist das Gebiet um den Shinto-Kern herum gemeint. Hier befinden sich vor allem Wohngebiete, aber auch eine noch immer vorhandene Zahl an Einkaufszentren und Geschäften. 
                                Es gibt hier mehrere Bäume, doch die Hochhäuser und Bauten sind weiterhin präsent.'
        ),
        'Miyamachou' => array(
            'Name' => 'Miyamachou',
            'img' => 'Miyamachou',
            'Beschreibung' => 'In Miyama befinden sich vor allem kleine Bauten, Häuser und Geschäfte. 
                Es ist das zentrale Viertel und wird im Norden von Miyama-Nord, sowie im Süden von Miyama-Süd eingegrenzt. 
                Die Gebäude sind einer japanischen Kleinstadt angemessen und in der Nähe der Fuyuki-Brücke befinden sich zahlreiche kleine Parks und Grünanlagen. 
                Es gibt hier viele Wohnungen für den Mittelstand Fuyukis, während in Fuyuki-Nord und Süd vor allem die vermögenderen Einwohner beheimatet sind. 

                Es gibt hier sehr viele Bäume, ganz besonders im Frühjahr ist Miyamachou von Kirschblüten übersät'
        ),
        'Miyama-Nord' => array(
            'Name' => 'Miyama-Nord',
            'img' => 'MiyamaNord',
            'Beschreibung' => 'Miyama-Nord ist von sehr alten Gebäuden geprägt, die im japanisch-traditionellem Stil errichtet wurden. Es gibt hier keine Läden oder Geschäfte, jedoch eine große Anzahl von Gärten, kleinen Parks und Anwesen. 
                                Miyama-Nord ist wie Miyama-Süd auf einem Hügel errichtet worden, weshalb es viele Treppen gibt und der Weg nicht eben verläuft'
        ),
        'Miyama-Sued' => array(
            'Name' => 'Miyama-Süd',
            'img' => 'MiyamaSued',
            'Beschreibung' => 'Miyama-Süd ist von sehr alten Gebäuden geprägt, die im westlich-europäischem Stil errichtet wurden. 
                Es gibt hier einige wenige Läden oder Geschäfte, doch der Großteil des Viertels ist von Reihenhäusern und Villen geprägt. 
                Miyama-Süd ist wie Miyama-Nord auf einem Hügel errichtet worden, weshalb es viele Treppen gibt und der Weg nicht eben verläuft.'
        ),
    );


    public function getOrtePreview($name) {
        if(key_exists($name, $this->orteArray)){
            return $this->orteArray[$name];
        }
    }
    
    
    public function getStadtteilPreview($name) {
        if(key_exists($name, $this->stadtteilArray)){
            return $this->stadtteilArray[$name];
        }
    }
    
}
