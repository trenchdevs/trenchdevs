import{T as m}from"./TrenchDevsAdminLayout.cbafbeae.js";import{b as o,j as a,a as s,L as c}from"./app.c0efc5b0.js";import{S as d}from"./skip-back.ce853298.js";import{S as h}from"./save.2a505807.js";function N(t){const{user:n={},errors:l={}}=t,r=o({first_name:"",last_name:"",email:"",is_active:"0",password:"",role:"",...n});function i(e){e.preventDefault(),r.post("/dashboard/users")}return a(m,{children:s("div",{className:"card mb-4",children:[a("div",{className:"card-header",children:"Create User"}),a("div",{className:"card-body",children:a("form",{onSubmit:i,children:s("div",{className:"row",children:[s("div",{className:"form-group col-6",children:[a("label",{htmlFor:"first-name",children:"First Name"}),a("input",{className:"form-control",id:"first-name",name:"first_name",type:"text",value:r.data.first_name,onChange:e=>r.setData(e.target.name,e.target.value)}),l.first_name&&a("div",{className:"text-danger",children:l.first_name})]}),s("div",{className:"form-group col-6",children:[a("label",{htmlFor:"last-name",children:"Last Name"}),a("input",{className:"form-control",id:"last-name",name:"last_name",type:"text",value:r.data.last_name,onChange:e=>r.setData(e.target.name,e.target.value)}),l.last_name&&a("div",{className:"text-danger",children:l.last_name})]}),s("div",{className:"form-group col-6",children:[a("label",{htmlFor:"email",children:"Email"}),a("input",{readOnly:r.data.id,className:"form-control",id:"email",name:"email",type:"email",value:r.data.email,onChange:e=>r.setData(e.target.name,e.target.value)}),l.email&&a("div",{className:"text-danger",children:l.email})]}),s("div",{className:"form-group col-6",children:[a("label",{htmlFor:"is-active",children:"Is Active"}),s("select",{className:"form-control",id:"is-active",name:"is_active",onChange:e=>r.setData(e.target.name,e.target.value),children:[a("option",{value:"0",children:"No"}),a("option",{value:"1",children:"Yes"})]}),l.is_active&&a("div",{className:"text-danger",children:l.is_active})]}),s("div",{className:"form-group col-6",children:[a("label",{htmlFor:"password",children:"Password"}),a("input",{className:"form-control",id:"password",name:"password",type:"password",onChange:e=>r.setData(e.target.name,e.target.value),value:r.data.password}),l.password&&a("div",{className:"text-danger",children:l.password})]}),a("div",{className:"col-6"}),s("div",{className:"form-group col-6",children:[s("label",{htmlFor:"role",children:["Role ",a("br",{}),a("small",{children:"admin, contributor, business_owner, customer"})]}),a("input",{className:"form-control",id:"role",name:"role",type:"text",onChange:e=>r.setData(e.target.name,e.target.value),value:r.data.role}),l.role&&a("div",{className:"text-danger",children:l.role})]}),s("div",{className:"col-12 text-right",children:[s(c,{className:"btn btn-warning mr-2",href:"/dashboard/users",children:[a(d,{size:14}),a("span",{className:"ml-2",children:"Cancel"})]}),s("button",{className:"btn btn-success",children:[a(h,{size:14}),a("span",{className:"ml-2",children:"Save"})]})]})]})})})]})})}export{N as default};