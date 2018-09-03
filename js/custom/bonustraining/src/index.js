import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import {Provider} from "react-redux";

import store from "./Store";

const accessKey = document.getElementById('accessKey').innerHTML.trim();

ReactDOM.render(
    <Provider store={store}>
        <App apiKey={accessKey}/>
    </Provider>,
    document.getElementById("root")
);
