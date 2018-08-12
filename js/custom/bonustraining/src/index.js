import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import {Provider} from "react-redux";

import store from "./Store";


const accessKey = 'SOME_KEY_TO_BE_FETCHED_BY_I_DONT_KNOW_YET_WHAT_WAY';

ReactDOM.render(
    <Provider store={store}>
        <App apiKey={accessKey}/>
    </Provider>,
    document.getElementById("root")
);
