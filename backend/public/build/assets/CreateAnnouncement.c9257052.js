import{C as s}from"./Card.cacc57cb.js";import{F as t}from"./FormInput.dec2e0f3.js";import{b as i,j as e,a as r}from"./app.fb91ff64.js";import{T as l}from"./TrenchDevsAdminLayout.8855af96.js";function h(){const a=i({title:"",message:"",emails:""});function n(){a.post("/dashboard/announcements/create")}return e(l,{children:e(s,{header:"Create Announcement",children:r("div",{children:[r("div",{className:"form-group",children:[e("label",{htmlFor:"title",children:"Title / Subject"}),e(t,{name:"title",className:"form-control",form:a,type:"input"})]}),r("div",{className:"form-group",children:[e("label",{htmlFor:"message",children:"Message"}),e(t,{name:"message",form:a,type:"rich-text-editor"})]}),r("div",{className:"form-group",children:[e("label",{htmlFor:"emails",children:"Email Addresses (CSV) "}),e(t,{className:"form-control",name:"emails",form:a,type:"textarea"})]}),e("div",{className:"alert alert-info",children:"Note: If no emails are specified, by default this creates an activity feed and emails all participants in the TrenchDevs account."}),e("div",{className:"row",children:e("div",{className:"col text-right",children:e("button",{className:"btn btn-success",onClick:n,children:"Announce"})})})]})})})}export{h as default};