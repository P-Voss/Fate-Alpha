import React from 'react';

import Attribute from './Attribute'

export default ({attributes = {}}) => {
    return (
        <div>
            <Attribute attributeName='Stärke' attributeStats={attributes.Str} />
            <Attribute attributeName='Agilität' attributeStats={attributes.Agi} />
            <Attribute attributeName='Ausdauer' attributeStats={attributes.End} />
            <Attribute attributeName='Kontrolle' attributeStats={attributes.Con} />
            <Attribute attributeName='Disziplin' attributeStats={attributes.Dis} />
            <Attribute attributeName='Übung' attributeStats={attributes.Pra} />
        </div>
    );
}
