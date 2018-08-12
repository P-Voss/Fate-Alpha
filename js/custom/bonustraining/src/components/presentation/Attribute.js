import React from 'react';
import Typography from '@material-ui/core/Typography';
import { withStyles } from '@material-ui/core/styles';

const styles = {
    label: {
        display: 'inline-block',
        width: '170px'
    },
    category: {
        display: 'inline-block',
        width: '70px',
        fontWeight: 'bold'
    },
    value: {
        display: 'inline-block',
        width: '70px'
    }
};

export default withStyles(styles)(({attributeName, attributeStats, classes}) => {
    return (
        <div>
            <span className={classes.label}>
                <Typography variant={"body1"}>
                    {attributeName}
                </Typography>
            </span>
            <span className={classes.value}>
                {attributeStats.value}
            </span>
            <span className={classes.category}>
                {attributeStats.category}
            </span>
        </div>
    );
})
