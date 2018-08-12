import React from 'react';
import Typography from '@material-ui/core/Typography';

export default ({remainingDays = 0}) => {
    return (
        <div>
            <Typography variant={'display1'}>Verfügbare Tage: {remainingDays}</Typography>
        </div>
    );
};