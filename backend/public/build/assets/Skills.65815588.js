import{T as m}from"./TrenchDevsAdminLayout.8855af96.js";import{P as a}from"./PortfolioStepper.81bdc966.js";import{u as l,b as p,a as n,j as r}from"./app.fb91ff64.js";import{C as c}from"./Card.cacc57cb.js";import{D as d}from"./DynamicForm.779b696c.js";import"./FormInput.dec2e0f3.js";import"./save.b076330f.js";function F(f){const o=l(),{skills:e={},auth:u={}}=o.props,s=p({...e||{}});function t(){s.post("/dashboard/portfolio/skills",{preserveScroll:i=>Object.keys(i.props.errors).length})}return n(m,{children:[r(a,{activeStep:3}),r("div",{className:"row",children:r("div",{className:"col",children:r(c,{header:"Skills",children:r(d,{inertiaForm:s,formElements:o.props.dynamic_form_elements,onSubmit:t})})})})]})}export{F as default};
