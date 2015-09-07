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
        'Emiya' => array(
            'Name' => 'Emiya',
            'img' => 'Emiya',
            'Beschreibung' => 'Die Magi-Familie der Emiya besitzt hier ein Anwesen, recht nahe an Miyamachou gelegen.'
        ),
        'Bruecke' => array(
            'Name' => 'Brücke',
            'img' => 'Bruecke',
            'Beschreibung' => 'Die Fuyuki-Brücke ist ein zentraler Teil der Stadt, indem sie Shinto und Miyamachou miteinander verbindet. 
                                Sie ist in ihrer Mitte für Fahrzeuge reserviert, während man links wie rechts der Straße einen Fußgängerübergang hat. 
                                Sie zu überqueren kann zu Fuß etwa 20 Minuten dauern, wenn man sich beeilt oder gar läuft, geht es schneller. 
                                Die Brücke ist sehr stabil und wird sie am Tag auch häufig genutzt, wird sie Nachts so gut wie nie betreten.'
        ),
        'Promenade' => array(
            'Name' => 'Promenade',
            'img' => 'Promenade',
            'Beschreibung' => 'Good place to fight'
        ),
        'Kirche' => array(
            'Name' => 'Kirche',
            'img' => 'Kirche',
            'Beschreibung' => 'Die Kirche wird auch "Kotomine Kirche" genannt, da sie seit jeher von Mitgliedern der Kotomine-Familie geleitet wurde. 
                                Sie spielt im Gralskrieg eine besondere Rolle da das Oberhaupt der Kirche auch der Supervisor und damit die 
                                Aufsichtsperson des Gralskrieges ist. Master können jederzeit in der Kirche Schutz erbitten oder den Supervisor um Rat bitten.<br /> 
                                Ausserhalb der Kirche befindet sich ein Friedhof, an welchem Besucher aus Shinto vorbeikommen. 
                                Innen besteht sie aus einer großen Gebetshalle, in welcher die Gäste willkommen geheißen werden. 
                                Es gibt jedoch eine Vielzahl von Gängen und Räumen in der Kirche, die von den Kotomine seit einem guten Jahrhundert bewohnt werden. 
                                Jeden Sonntag wird hier ein Gottesdienst abgehalten, in der Woche gibt es jedoch keinen. <br />
                                Die Kirche selbst befindet sich auf einem kleinen Hügel und ist bereits aus weiter Ferne zu erkennen. 
                                Von Shinto-Kizaka aus, benötigt man im Gang etwa 20 Minuten um zur Kirche zu kommen.'
        ),
        'Tohsaka' => array(
            'Name' => 'Tohsaka',
            'img' => 'Tohsaka',
            'Beschreibung' => 'Die Tohsaka besitzen hier ein Anwesen, welches sich auf dem höchsten Punkt des Miyama-Hügels befindet und am weitesten ausgebaut ist.'
        ),
        'Matou' => array(
            'Name' => 'Matou',
            'img' => 'Matou',
            'Beschreibung' => 'Die Matou besitzen hier ein Anwesen, welches sich im Schatten der Fuyuki-abgewandten Seite des Hügels befindet.'
        ),
        'Tempel' => array(
            'Name' => 'Tempel',
            'img' => 'Tempel',
            'Beschreibung' => 'Der alte Tempel welcher sich südwestlich von Miyama befindet.
                                Er ist nur über eine lange Treppe zu erreichen, welche durch den dichten Wald hindurch zum Tempeltor führt. 
                                Die Treppe ist zu Fuß etwa eine Stunde von Miyamachou entfernt und man benötigt etwas eine halbe Stunde 
                                um die Treppe hinauf bis zu ihrem Ende zu steigen. Sie ist allerdings zu weiten Teilen hin nicht sehr 
                                steil und es gibt mehrere Passagen in denen man lediglich geradeaus geht.
                                <br/>
                                Der Tempel besteht aus zwei Hauptgebäuden, welche über eine Passage miteinander 
                                verbunden sind. Es gibt ein Zeremoniengebäude und eine Ruhestätte. 
                                Die Mönche die diesen Tempel bewohnen gelten als hilfsbereit und friedlich.'
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
                                so dass sich hier nur ein paar Dutzend aneinandergereihte Lagerhallen und Bars vorfinden.<br /> 
                                Der Teil des Hafens an welchem Passagiere aus dem Ausland empfangen werden, besteht 
                                hauptsächlich aus einer Straße die aus dem Hafengebiet heraus in Shinto hinein führt.'
        ),
        'Shopping' => array(
            'Name' => 'Shopping',
            'img' => 'Shopping',
            'Beschreibung' => 'Im Zentrum Miyamachous befindet sich eine weite Straße mit vielen kleinen Geschäften und Läden, die sich im ständigen Preiskampf mit den großen Firmen in Shinto befinden.'
        ),
        'Schule' => array(
            'Name' => 'Schule',
            'img' => 'Schule',
            'Beschreibung' => 'Die High-School der Stadt befindet sich im äussersten Westen des Viertels und mit dem Rücken an die Wälder gelehnt in denen sich auch der Tempel befindet.'
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
