import React from 'react';

const Nutrients = (props) => {
    const facts = props.facts ? props.facts : {};

    let nutrients = JSON.parse( JSON.stringify( wprm_admin_modal.nutrition ) );
    delete nutrients.serving_size;

    return (
        <div className="wprm-admin-modal-recipe-nutrition-calculation-nutrients" id={ `wprm-admin-modal-recipe-nutrition-calculation-nutrients-${props.id}` }>
            {
                Object.keys(nutrients).map((nutrient, index) => {
                    const options = nutrients[ nutrient ];

                    // Don't show calculated fields.
                    if ( 'calculated' === options.type ) {
                        return null;
                    }

                    let value = false;

                    if ( facts.hasOwnProperty( nutrient ) ) {
                        value = facts[ nutrient ];
                    }

                    return (
                        <div className="wprm-admin-modal-recipe-nutrition-calculation-nutrient" key={index}>
                            <input
                                type="text"
                                id={ `wprm-admin-modal-recipe-nutrition-calculation-nutrient-${props.id}-${index}` }
                                value={ value ? value : "" }
                                onChange={ (e) => {
                                    const newValue = e.target.value;
                                    props.onChange( nutrient, newValue );
                                }}
                                disabled={ ! props.hasOwnProperty( 'onChange' ) }
                            />
                            <label
                                htmlFor={ `wprm-admin-modal-recipe-nutrition-calculation-nutrient-${props.id}-${index}` }
                            >{ options.unit } { options.label }</label>
                        </div>
                    );
                })
            }
        </div>
    );
}
export default Nutrients;