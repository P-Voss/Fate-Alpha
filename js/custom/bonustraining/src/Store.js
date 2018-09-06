import {createStore, applyMiddleware} from "redux";
import thunkMiddleware from "redux-thunk";

import trainingApp from "./reducers/Reducer";


// import {createLogger} from "redux-logger";
// import {composeWithDevTools} from "redux-devtools-extension";
// let middleware = applyMiddleware(thunkMiddleware);
// if (process.env.REACT_APP_ENV === "development") {
//     const loggerMiddleware = createLogger();
//     middleware = composeWithDevTools(applyMiddleware(thunkMiddleware, loggerMiddleware));
// }

const store = createStore(
    trainingApp,
    applyMiddleware(thunkMiddleware)
);

export default store;