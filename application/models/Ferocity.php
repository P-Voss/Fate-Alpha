<?php


class Application_Model_Ferocity
{


    public static function getDescription ($key): string
    {
        switch ($key) {
            case 'A':
                return <<<HTML
<ul>
<li>Bluterbler auf dieser Stufe erinnern von ihrem Verhalten oftmals eher an Tiere als an Menschen. Sie gelten als sehr mächtig, gefährlich und unberechenbar.</li>
<li>Er kann einmal je Plot entweder die Fähigkeit von Wildheit E oder die von Wildheit B anwenden ohne die zugehörigen Kosten bezahlen zu müssen.</li>
<li>Bei 0 Beherrschung verlieren sie augenblicklich ihren Verstand und erleiden <strong>Wahnsinn</strong>.</li>
</ul>
HTML;
            case 'B':
                return <<<HTML
<ul>
<li>Wilde und aufbrausende Bluterbler befinden sich häufig auf dieser Stufe. Ihre oftmals raue Art und fixierenden Pupillen lassen oft auch ohne weitere Fähigkeiten auf einen Bluterbler schließen.</li>
<li>Der Charakter zählt auf dieser Stufe immer als "Nicht-Mensch".</li>
<li>
    Er erhält im Kampf die Fähigkeit (Bonusaktion) einen versteckten/verborgenen Feind zum Ziel eines Kern-Angriffes zu erklären, 
    den er durch Ausreizung seiner Instinkte sofort aufspüren und angreifen wird. Sollte der Feind für den Bluterbler in 
    diesem Rundendrittel selbst bei ausfindig machen nicht erreichbar sein, wird diese Fähigkeit nicht aktiviert. 
    Der Bluterbler erhält nicht Bescheid, wo sich der Gegner befindet und wird diesen auch nicht angreifen.<br />
    Die Kosten der Fähigkeit nach Aktivierung ist der Wechsel auf Wildheitstufe A.
</li>
<li>Bei 0 Beherrschung fallen sie auf Wildheit A und regenerieren ihre Beherrschung anschließend.</li>
</ul>
HTML;
            case 'C':
                return <<<HTML
<ul>
<li>Die meisten erwachsenen Bluterbler befinden sich in dieser Stufe. Sie wirken noch immer wie normale Menschen, doch in bestimmten Momenten erkennt man ihre aggressivere Natur.</li>
<li>Fähigkeiten und Regeln die nur bei "Nicht-Menschen" Anwendung finden, entfalten ihre Wirkung bei diesem Bluterbler nur dann wenn er Mordlust aktiviert hat. </li>
</ul>
HTML;
            case 'D':
                return <<<HTML
<ul>
<li>Die meisten jüngeren Bluterbler befinden sich auf dieser Stufe und sind häufig kaum von normalen Menschen zu unterscheiden.</li>
<li>Fähigkeiten und Regeln die nur bei "Nicht-Menschen" Anwendung finden, entfalten ihre Wirkung bei diesem Bluterbler nur dann wenn er von ihnen profitieren würde.</li>
</ul>
HTML;
            case 'E':
                return <<<HTML
<ul>
<li>Bluterbler auf dieser Stufe lassen sich nicht von normalen Menschen unterscheiden.</li>
<li>Der Charakter zählt auf dieser Stufe niemals als "Nicht-Mensch". </li>
<li>Er erhält im Kampf die Fähigkeit (Bonusaktion) den im aktuellen Rundendrittel erhaltenen Schaden um 30HP zu reduzieren. Sollte der Schaden unter 30HP liegen, wird der überschüssige Wert als Heilung angerechnet welche für den Zeitraum des Kampfes über das Maximum der Lebenspunkte hinausgehen kann. Fand kein HP-Schaden statt, dann wird diese Fähigkeit nicht aktiviert. 
Die Kosten der Fähigkeit nach Aktivierung ist der Wechsel auf Wildheitstufe C.</li>
</ul>
HTML;
        }
    }

}