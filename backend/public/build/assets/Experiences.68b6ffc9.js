import{T as c}from"./TrenchDevsAdminLayout.8a93d73e.js";import{P as m}from"./PortfolioStepper.d4d9f32f.js";import{u as t,b as n,a as o,j as e}from"./app.d4ee405e.js";import{D as p}from"./DynamicListForm.0408be0e.js";import"./FormInput.3bc6aa97.js";import"./plus.99463bb4.js";import"./save.295519a0.js";function y(d){const r=t(),s=n([...r.props.experiences||[]]);function i(){s.post("/dashboard/portfolio/experiences",{preserveScroll:a=>Object.keys(a.props.errors).length})}return o(c,{children:[e(m,{activeStep:1}),e("div",{className:"row",children:e("div",{className:"col",children:o("div",{className:"card",children:[e("div",{className:"card-header",children:"Experiences"}),e("div",{className:"card-body",children:e(p,{inertiaForm:s,entryVerbiage:"Experience",formElements:r.props.dynamic_form_elements,onSubmit:i})})]})})})]})}export{y as default};
