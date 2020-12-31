import React, { Fragment } from 'react';

const Step = (props) => {
    return (


        props.steps.map((item, index) => (
            <Fragment>
            <div key={index} className="step" data-target={item.target}>
                <button className="step-trigger" disabled>
                    <span className="bs-stepper-circle">{item.number}</span>
                    <span className="bs-stepper-label">{item.text}</span>
                </button>
            </div>
             <div   className="line"></div>
             </Fragment>
        ))


    );
}

export default Step;

