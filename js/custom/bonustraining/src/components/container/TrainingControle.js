import React, {Component} from "react";
import {connect} from "react-redux";
import {bindActionCreators} from "redux";

import Grid from "@material-ui/core/Grid";
import Typography from "@material-ui/core/Typography";
import InputLabel from "@material-ui/core/InputLabel";
import MenuItem from "@material-ui/core/MenuItem";
import FormControl from "@material-ui/core/FormControl";
import Select from "@material-ui/core/Select";
import Button from "@material-ui/core/Button";
import TextField from "@material-ui/core/TextField";
import {withStyles} from "@material-ui/core/styles";

import * as actions from "../../actions/ActionTypes";

const styles = {
    Select: {
        width: 200
    },
    TextField: {
        width: 80
    }
};

class TrainingControle extends Component {
    constructor(props) {
        super(props);
        this.state = {
            currentlyChosenTraining: 0,
            selectedDays: 0
        };
        this.changeProgram = this.changeProgram.bind(this);
        this.setTrainingDays = this.setTrainingDays.bind(this);
    }

    changeProgram(event) {
        this.setState({...this.state, currentlyChosenTraining: event.target.value});
    }

    setTrainingDays(event) {
        this.setState({...this.state, selectedDays: event.target.value});
    }

    render() {
        const {currentlyChosenTraining, selectedDays} = this.state;
        const {programs, classes} = this.props;
        return (
            <Grid container spacing={16}>
                <Typography variant={"headline"} align={"left"}>Training auswählen</Typography>
                <Grid item md={12}>
                    <FormControl>
                        <InputLabel>Trainingsprogramm</InputLabel>
                        <Select
                            onChange={(event) => this.changeProgram(event)}
                            className={classes.Select}
                            value={currentlyChosenTraining}>
                            <MenuItem value={0}>Bitte wählen</MenuItem>
                            {programs.map((program, key) => {
                                return <MenuItem key={key} value={program.programId}>{program.name}</MenuItem>;
                            })}
                        </Select>
                    </FormControl>
                </Grid>
                <Grid item md={12}>
                    <TextField
                        onChange={(event) => this.setTrainingDays(event)}
                        className={classes.TextField}
                        id="days"
                        label="Trainingstage"
                        value={selectedDays}
                        type="number"/>
                </Grid>
                <Grid item md={12}>
                    <Button variant={"contained"} color={"primary"}>Training durchführen</Button>
                </Grid>
            </Grid>
        );
    }
}


function mapStateToProps(state) {
    return {...state};
}

function mapDispatchToProps(dispatch) {
    return {
        actions: bindActionCreators(actions, dispatch)
    };
}

export default withStyles(styles)(connect(
    mapStateToProps,
    mapDispatchToProps
)(TrainingControle));
