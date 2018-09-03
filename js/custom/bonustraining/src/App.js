import React, {Component} from "react";
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import Grid from '@material-ui/core/Grid'
import Typography from '@material-ui/core/Typography';

import Header from './components/presentation/Header'
import Attributes from './components/presentation/Attributes'
import TrainingProgramList from './components/presentation/TrainingProgramList'
import TrainingControle from './components/container/TrainingControle'

import "./App.css";

import * as trainingActions from './actions/ActionTypes'
import * as characterActions from './actions/CharacterActionTypes'

class App extends Component {
    constructor(props) {
        super(props);
        props.trainingActions.loadTrainingPrograms(this.props.apiKey);
        props.characterActions.loadCharacterAttributes(this.props.apiKey);
        this.triggerTraining = this.triggerTraining.bind(this);
    }
    componentDidMount() {

    }

    triggerTraining(programId, days) {
        this.props.trainingActions.executeTraining(programId, days, this.props.apiKey);
    }

    render() {
        const {remainingDays, characterAttributes, trainingPrograms} = this.props;

        return (
            <div className="App">
                <Grid item md={12}>
                    <Header remainingDays={remainingDays} />
                </Grid>
                <Grid container>
                    <Grid item md={6}>
                        <TrainingControle programs={trainingPrograms} triggerTraining={this.triggerTraining} />
                    </Grid>
                    <Grid item md={6}>
                        <Typography variant={"headline"} align={"left"}>Aktuelle Werte</Typography>
                        <Attributes attributes={characterAttributes}/>
                    </Grid>
                </Grid>
                <TrainingProgramList programs={trainingPrograms} />
            </div>
        );
    }
}


function mapStateToProps(state) {
    return {...state};
}

function mapDispatchToProps(dispatch) {
    return {
        trainingActions: bindActionCreators(trainingActions, dispatch),
        characterActions: bindActionCreators(characterActions, dispatch)
    };
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(App);
