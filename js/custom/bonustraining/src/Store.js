import {createStore, applyMiddleware} from "redux";
import {createLogger} from "redux-logger";
import thunkMiddleware from "redux-thunk";

import { composeWithDevTools } from 'redux-devtools-extension';

import trainingApp from "./reducers/Reducer";

const loggerMiddleware = createLogger()

const store = createStore(
    trainingApp,
    composeWithDevTools(
        applyMiddleware(
            thunkMiddleware, // lets us dispatch() functions
            loggerMiddleware, // neat middleware that logs actions
        )
    )
);

export default store;