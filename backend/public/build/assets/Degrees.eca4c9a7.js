import{T as m}from"./TrenchDevsAdminLayout.8855af96.js";import{P as t}from"./PortfolioStepper.81bdc966.js";import{u as c,b as p,a as s,j as e}from"./app.fb91ff64.js";import{D as d}from"./DynamicListForm.fdb021df.js";import"./FormInput.dec2e0f3.js";import"./trash.4f3a0a3e.js";import"./plus.95644f78.js";import"./save.b076330f.js";function D(n){const r=c(),o=p([...r.props.degrees||[]]);function a(){o.post("/dashboard/portfolio/degrees",{preserveScroll:i=>Object.keys(i.props.errors).length})}return s(m,{children:[e(t,{activeStep:2}),e("div",{className:"row",children:e("div",{className:"col",children:s("div",{className:"card",children:[e("div",{className:"card-header",children:"Degrees"}),e("div",{className:"card-body",children:e(d,{inertiaForm:o,entryVerbiage:"Degree",formElements:r.props.dynamic_form_elements,onSubmit:a})})]})})})]})}export{D as default};