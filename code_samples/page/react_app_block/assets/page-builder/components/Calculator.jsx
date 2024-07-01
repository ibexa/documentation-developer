import React from 'react';

export default function (props) {
    // a + b = ...
    console.log("Hello React!");
    return <div>{props.a} + {props.b} = {parseInt(props.a) + parseInt(props.b)}!</div>;
}
