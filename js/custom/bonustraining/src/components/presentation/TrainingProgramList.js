import React from 'react';
import TrainingProgram from './TrainingProgram'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid'

export default ({programs = []}) => {
    return (
        <div>
            <Typography variant={"display1"}>Trainingsprogramme</Typography>

            <Grid container spacing={16}>
            {programs.map((program, key) => {
                return <Grid key={key} item xs={12} sm={6} md={4}><TrainingProgram {...program} key={key}/></Grid>
            })}
            </Grid>
        </div>
    )
};
