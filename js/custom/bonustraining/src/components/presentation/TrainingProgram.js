import React from 'react';
import Typography from '@material-ui/core/Typography';
import {withStyles} from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Chip from '@material-ui/core/Chip';
import Grid from '@material-ui/core/Grid';

import ExpansionPanel from '@material-ui/core/ExpansionPanel';
import ExpansionPanelSummary from '@material-ui/core/ExpansionPanelSummary';
import ExpansionPanelDetails from '@material-ui/core/ExpansionPanelDetails';

const styles = {
    Paper: {
        width: "87%",
        padding: "10px"
    }
};

const keys = new Map()
    .set('staerke', 'Stärke')
    .set('agilitaet', 'Agilität')
    .set('ausdauer', 'Ausdauer')
    .set('kontrolle', 'Kontrolle')
    .set('uebung', 'Übung')
    .set('disziplin', 'Disziplin');

const format = number =>  number > 0 ? "+" + number : number.toString();

const program = ({name, description, primary, secondary, optional = [], decreasing = [], classes}) => {
    return (
        <Paper className={classes.Paper}>
            <Typography variant={"headline"} align={"left"}>{name}</Typography>
            <Typography variant={"body2"}>{description}</Typography>
            <Grid container>
                <Grid item md={6}><Typography variant={"body1"}>Fokus: </Typography></Grid>
                <Grid item md={6}><Chip label={keys.get(primary.attribute) + " " + format(primary.value)}/></Grid>
                <Grid item md={6}><Typography variant={"body1"}>Sekundär: </Typography></Grid>
                <Grid item md={6}><Chip label={keys.get(secondary.attribute) + " " + format(secondary.value)}/></Grid>
            </Grid>

            <ExpansionPanel>
                <ExpansionPanelSummary>
                    <Typography variant={"body1"}>Trainiert einen Wert</Typography>
                </ExpansionPanelSummary>
                <ExpansionPanelDetails>
                    {optional.map((attr, key) => <Chip key={key} label={keys.get(attr.attribute) + " " + format(attr.value)}/>)}
            </ExpansionPanelDetails>
            </ExpansionPanel>
            <ExpansionPanel>
                <ExpansionPanelSummary>
                    <Typography variant={"body1"}>Vernachlässigt einen Wert</Typography>
                </ExpansionPanelSummary>
                <ExpansionPanelDetails>
                    <Grid container>
                        {decreasing.map((attr, key) => {
                            return (
                                <Grid key={key} item xs={6}>
                                    <Chip key={key} label={keys.get(attr.attribute) + " " + format(attr.value)}/>
                                </Grid>
                            )
                        })}
                    </Grid>
                </ExpansionPanelDetails>
            </ExpansionPanel>
        </Paper>
    )
}

export default withStyles(styles)(program);