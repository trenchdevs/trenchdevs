import{l as t}from"./TrenchDevsAdminLayout.8855af96.js";import{F as d}from"./FormInput.dec2e0f3.js";import{j as a,F as i,a as s}from"./app.fb91ff64.js";import{S as p}from"./save.b076330f.js";function b({inertiaForm:c,formElements:r,onSubmit:m}){return t.exports.isEmpty(r)?a(i,{}):s(i,{children:[a("div",{className:"row",children:Object.keys(r).map(e=>{const{wrapperClassName:n="",name:o,...l}=r[e];return a("div",{className:n,children:s("div",{className:"form-group",children:[s("label",{children:[e,l.verbiage&&s("small",{className:"ml-1",children:["(",l.verbiage,")"]})]}),a(d,{...l,name:o,form:c})]})},e)})}),a("div",{className:"row",children:a("div",{className:"col",children:a("div",{className:"mt-3",children:s("button",{className:"btn btn-success float-right",onClick:m,children:[a(p,{}),a("span",{className:"pl-1",children:"Save"})]})})})})]})}export{b as D};
