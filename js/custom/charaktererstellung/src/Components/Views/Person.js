import React, {Component} from 'react';
import TextField from '@material-ui/core/TextField';

import City from './City';

import Radio from '@material-ui/core/Radio';
import RadioGroup from '@material-ui/core/RadioGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormControl from '@material-ui/core/FormControl';
import FormLabel from '@material-ui/core/FormLabel';
import FormHelperText from '@material-ui/core/FormHelperText';

import Select from '@material-ui/core/Select';
import MenuItem from '@material-ui/core/MenuItem';
import Input from '@material-ui/core/Input';
import InputLabel from '@material-ui/core/InputLabel';

import Grid from '@material-ui/core/Grid';


class Person extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    render() {
        const {person, handleGenderChange, handleSexualityChange, handleEyecolorChange, handleSizeChange, handleSizeValidation, handleResidenceChange} = this.props;
        return (
            <React.Fragment>
                <h2>Dein Charakter</h2>
                <Grid container>
                    <Grid container spacing={8}>
                        <Grid item xs={10} sm={5}>
                            <TextField
                                label="Vorname"
                                helperText="Der Vorname hat keine Auswirkungen auf das Spiel."
                                defaultValue={person.firstname}
                            />
                        </Grid>
                        <Grid item xs={10} sm={5}>
                            <TextField
                                label="Nachname"
                                helperText="Solltet ihr später einem Clan beitreten, wird euer Nachname mit dem Namen des Clans ersetzt dem ihr angehört."
                                defaultValue={person.surname}
                            />
                        </Grid>
                    </Grid>
                    <Grid container style={{marginTop: '20px'}}>
                        <Grid item xs={10} sm={5}>
                            <FormControl component="fieldset">
                                <Grid container spacing={8}>
                                    <Grid item xs={6} sm={5}>
                                        <FormLabel component="legend">Geschlecht</FormLabel>
                                        <FormHelperText>Hat Auswirkungen auf die Liebes-Regel sowie
                                            Charme-Magien.</FormHelperText>
                                    </Grid>
                                    <Grid item xs={6} sm={5}>
                                        <RadioGroup
                                            aria-label="gender"
                                            name="gender"
                                            value={person.gender}
                                            onChange={handleGenderChange}
                                        >
                                            <FormControlLabel value="female" control={<Radio/>} label="Weiblich"/>
                                            <FormControlLabel value="male" control={<Radio/>} label="Männlich"/>
                                        </RadioGroup>
                                    </Grid>
                                </Grid>
                            </FormControl>
                        </Grid>
                        <Grid item xs={10} sm={5}>
                            <FormControl>
                                <InputLabel htmlFor="age-helper">Sexualität</InputLabel>
                                <Select
                                    value={person.sexuality}
                                    onChange={handleSexualityChange}
                                    input={<Input name="age" id="age-helper"/>}
                                >
                                    <MenuItem value="">
                                        <em>Bitte auswählen..</em>
                                    </MenuItem>
                                    <MenuItem value="hetero">Heterosexuell</MenuItem>
                                    <MenuItem value="homo">Homosexuell</MenuItem>
                                    <MenuItem value="bi">Bisexuell</MenuItem>
                                </Select>
                                <FormHelperText>
                                    Hat Auswirkungen auf die Liebes-Regel sowie Charme-Magien.
                                </FormHelperText>
                            </FormControl>
                        </Grid>
                    </Grid>
                    <Grid container spacing={8} style={{marginTop: '20px'}}>
                        <Grid item xs={12} sm={8}>
                            <FormLabel component="legend">
                                Geburtsdatum
                            </FormLabel>
                            <FormHelperText>
                                Der Charakter kann zwischen 12 und 90 Jahre alt sein.
                            </FormHelperText>
                            <FormHelperText>
                                Das Alter gibt die Gesellschaft und Bekanntenkreis an in welchem man sich
                                bei Spielbeginn befindet, hat aber auch Einfluss auf die eigenen Werte.
                            </FormHelperText>
                            <FormHelperText>
                                (12-15 Mittelstufe, 16-18 Oberstufe ,19+ Erwachsen, 50+ Alt).
                            </FormHelperText>
                        </Grid>
                        <Grid>
                            <TextField
                                id="date"
                                label="Geburtsdatum"
                                type="date"
                                defaultValue={person.dateOfBirth}
                                InputLabelProps={{
                                    shrink: true,
                                }}
                            />
                        </Grid>
                    </Grid>
                    <Grid container spacing={8} style={{marginTop: '20px'}}>
                        <Grid item xs={6} sm={5}>
                            <FormControl>
                                <InputLabel htmlFor="eyes-helper">Augenfarbe</InputLabel>
                                <Select
                                    value={person.eyeColor}
                                    onChange={handleEyecolorChange}
                                    input={<Input name="eyes" id="eyes-helper"/>}
                                    style={{width: '200px'}}
                                >
                                    <MenuItem value="">
                                        <em>Bitte auswählen..</em>
                                    </MenuItem>
                                    <MenuItem value="blue">Blau</MenuItem>
                                    <MenuItem value="yellow">Grün</MenuItem>
                                    <MenuItem value="grey">Grau</MenuItem>
                                    <MenuItem value="brown">Braun</MenuItem>
                                    <MenuItem value="black">Schwarz</MenuItem>
                                    <MenuItem value="red">Rot</MenuItem>
                                    <MenuItem value="yellow">Gelb</MenuItem>
                                    <MenuItem value="purple">Lila</MenuItem>
                                    <MenuItem value="turquoise">Türkis</MenuItem>
                                </Select>
                            </FormControl>
                        </Grid>
                        <Grid item xs={10} sm={5}>
                            <TextField
                                id="number"
                                label="Körpergröße"
                                value={person.size > 0 ? person.size : 165}
                                helperText="Der Charakter kann zwischen 130cm und 210cm groß sein."
                                type="number"
                                inputProps={{min: "130", max: "210", step: "1"}}
                                margin="normal"
                                onChange={handleSizeChange}
                                onBlur={handleSizeValidation}
                            />
                        </Grid>
                    </Grid>
                    <Grid container style={{marginTop: '20px'}}>
                        <Grid item xs={12} sm={5}>
                            <FormLabel>
                                Wohnort
                            </FormLabel>
                            <FormHelperText>
                                <a>
                                    Ort und Art der Wohnung des Charakters
                                </a>
                            </FormHelperText>
                        </Grid>
                        <Grid item xs={6} sm={5}>
                            <TextField label="Stadtteil" value={person.residence} disabled={true} />
                            <City residence={person.residence} handleResidenceChange={handleResidenceChange} />
                        </Grid>
                    </Grid>
                </Grid>

            </React.Fragment>
        );
    }
}

export default Person;