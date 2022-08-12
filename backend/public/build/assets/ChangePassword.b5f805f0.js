import{F as l}from"./FormInput.dec2e0f3.js";import{r as p,a as i,j as r,b as h,L as f}from"./app.fb91ff64.js";import{p as c,T as v}from"./TrenchDevsAdminLayout.8855af96.js";import{S as u}from"./save.b076330f.js";function w(e,o){if(e==null)return{};var n=b(e,o),s,a;if(Object.getOwnPropertySymbols){var t=Object.getOwnPropertySymbols(e);for(a=0;a<t.length;a++)s=t[a],!(o.indexOf(s)>=0)&&(!Object.prototype.propertyIsEnumerable.call(e,s)||(n[s]=e[s]))}return n}function b(e,o){if(e==null)return{};var n={},s=Object.keys(e),a,t;for(t=0;t<s.length;t++)a=s[t],!(o.indexOf(a)>=0)&&(n[a]=e[a]);return n}var d=p.exports.forwardRef(function(e,o){var n=e.color,s=n===void 0?"currentColor":n,a=e.size,t=a===void 0?24:a,m=w(e,["color","size"]);return i("svg",{ref:o,xmlns:"http://www.w3.org/2000/svg",width:t,height:t,viewBox:"0 0 24 24",fill:"none",stroke:s,strokeWidth:"2",strokeLinecap:"round",strokeLinejoin:"round",...m,children:[r("rect",{x:"3",y:"11",width:"18",height:"11",rx:"2",ry:"2"}),r("path",{d:"M7 11V7a5 5 0 0 1 10 0v4"})]})});d.propTypes={color:c.exports.string,size:c.exports.oneOfType([c.exports.string,c.exports.number])};d.displayName="Lock";const g=d,N={old_password:"",password:"",password_confirmation:""};function O(e){const o=h({...N});function n(s){s.preventDefault(),o.post("/dashboard/account/change-password"),o.reset()}return i(v,{children:[r("div",{className:"row mb-3",children:r("div",{className:"col",children:r("nav",{className:"nav nav-borders",children:r(f,{className:"p-0 nav-link active",href:"/dashboard/account/change-password",children:r("div",{className:"badge badge-blue-soft p-3",children:i("span",{className:"font-weight-bolder",children:[r(g,{className:"d-inline mr-2",size:12}),"Security"]})})})})})}),r("div",{className:"row",children:r("div",{className:"col-6",children:i("div",{className:"card mb-4",children:[r("div",{className:"card-header",children:"Change Password"}),r("div",{className:"card-body p-5",children:i("form",{onSubmit:n,children:[i("div",{className:"form-group",children:[r("label",{htmlFor:"old_password",children:"Old Password"}),r(l,{form:o,name:"old_password",className:"form-control",type:"password"})]}),i("div",{className:"form-group",children:[r("label",{htmlFor:"password",children:"Password"}),r(l,{form:o,name:"password",className:"form-control",type:"password"})]}),i("div",{className:"form-group",children:[r("label",{htmlFor:"password_confirmation",children:"Confirm Password"}),r(l,{form:o,name:"password_confirmation",className:"form-control",type:"password"})]}),i("button",{className:"btn btn-success float-right",children:[r(u,{className:"mr-2",size:16})," Save"]})]})})]})})})]})}export{O as default};