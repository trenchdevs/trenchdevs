import{T as a}from"./TrenchDevsAdminLayout.8855af96.js";import{P as c}from"./PortfolioStepper.81bdc966.js";import{u as m,b as n,a as e,j as r}from"./app.fb91ff64.js";import{D as p}from"./DynamicListForm.fdb021df.js";import"./FormInput.dec2e0f3.js";import"./trash.4f3a0a3e.js";import"./plus.95644f78.js";import"./save.b076330f.js";function g(d){const i=m(),o=n([...i.props.certifications||[]]);function s(){o.post("/dashboard/portfolio/certifications",{preserveScroll:t=>Object.keys(t.props.errors).length})}return e(a,{children:[r(c,{activeStep:2}),r("div",{className:"row",children:r("div",{className:"col",children:e("div",{className:"card",children:[r("div",{className:"card-header",children:"Certifications"}),r("div",{className:"card-body",children:r(p,{inertiaForm:o,entryVerbiage:"Certification",formElements:i.props.dynamic_form_elements,onSubmit:s})})]})})})]})}export{g as default};