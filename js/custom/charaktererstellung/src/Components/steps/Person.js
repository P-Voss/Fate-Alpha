import React, {Component} from 'react'
import TextField from '@material-ui/core/TextField'


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
        super(props)
        this.state = {
            anchorEl: null,
            popperOpen: false,
        }
        this.handlePopoverOpen = this.handlePopoverOpen.bind(this)
        this.handlePopoverClose = this.handlePopoverClose.bind(this)
    }
    handlePopoverOpen(event) {
        this.setState({ anchorEl: event.target });
    }
    handlePopoverClose(event) {
        this.setState({ anchorEl: null });
    }
    render() {
        const { person, handleGenderChange, handleSexualityChange } = this.props
        const { anchorEl, popperOpen } = this.state;
        const open = !!anchorEl
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
                    <Grid container style={{marginTop: '12px'}}>
                        <Grid item xs={10} sm={5}>
                            <FormControl component="fieldset">
                                <Grid container spacing={8}>
                                    <Grid item xs={6} sm={5}>
                                        <FormLabel component="legend">Geschlecht</FormLabel>
                                        <FormHelperText>Hat Auswirkungen auf die Liebes-Regel sowie Charme-Magien.</FormHelperText>
                                    </Grid>
                                    <Grid item xs={6} sm={5}>
                                        <RadioGroup
                                            aria-label="gender"
                                            name="gender"
                                            value={person.gender}
                                            onChange={handleGenderChange}
                                        >
                                            <FormControlLabel value="female" control={<Radio />} label="Weiblich" />
                                            <FormControlLabel value="male" control={<Radio />} label="Männlich" />
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
                                    input={<Input name="age" id="age-helper" />}
                                >
                                    <MenuItem value="">
                                        <em>Bitte auswählen..</em>
                                    </MenuItem>
                                    <MenuItem value="hetero">Heterosexuell</MenuItem>
                                    <MenuItem value="homo">Homosexuell</MenuItem>
                                    <MenuItem value="bi">Bisexuell</MenuItem>
                                </Select>
                                <FormHelperText>Hat Auswirkungen auf die Liebes-Regel sowie Charme-Magien.</FormHelperText>
                            </FormControl>
                        </Grid>
                    </Grid>
                    <Grid container spacing={8} style={{marginTop: '12px'}}>
                        <Grid item xs={12} sm={8}>
                            <FormLabel component="legend">Geburtsdatum</FormLabel>
                            <FormHelperText>Der Charakter kann zwischen 12 und 90 Jahre alt sein.</FormHelperText>
                            <FormHelperText>Das Alter gibt die Gesellschaft und Bekanntenkreis an in welchem man sich bei Spielbeginn befindet, hat aber auch Einfluss auf die eigenen Werte.</FormHelperText>
                            <FormHelperText>(12-15 Mittelstufe, 16-18 Oberstufe ,19+ Erwachsen, 50+ Alt).</FormHelperText>
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
                </Grid>

            </React.Fragment>
        )
    }
}

export default Person