import{a as e,u as g,r as h,j as r,H as f,L as b}from"./app.36d5bcee.js";import{G as x,B as w}from"./Guest.ce004124.js";import{V as y,I as l}from"./ValidationErrors.75e2974c.js";import{L as i}from"./Label.20ab8cf6.js";import"./ApplicationLogo.3e96a9e1.js";function N({name:t,value:o,handleChange:s}){return e("input",{type:"checkbox",name:t,value:o,className:"rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50",onChange:n=>s(n)})}function E({status:t,canResetPassword:o}){const{data:s,setData:n,post:c,processing:d,errors:u,reset:p}=g({email:"",password:"",remember:""});h.exports.useEffect(()=>()=>{p("password")},[]);const m=a=>{n(a.target.name,a.target.type==="checkbox"?a.target.checked:a.target.value)};return r(x,{children:[e(f,{title:"Log in"}),t&&e("div",{className:"mb-4 font-medium text-sm text-green-600",children:t}),e(y,{errors:u}),r("form",{onSubmit:a=>{a.preventDefault(),c(route("login"))},children:[r("div",{children:[e(i,{forInput:"email",value:"Email"}),e(l,{type:"text",name:"email",value:s.email,className:"mt-1 block w-full",autoComplete:"username",isFocused:!0,handleChange:m})]}),r("div",{className:"mt-4",children:[e(i,{forInput:"password",value:"Password"}),e(l,{type:"password",name:"password",value:s.password,className:"mt-1 block w-full",autoComplete:"current-password",handleChange:m})]}),e("div",{className:"block mt-4",children:r("label",{className:"flex items-center",children:[e(N,{name:"remember",value:s.remember,handleChange:m}),e("span",{className:"ml-2 text-sm text-gray-600",children:"Remember me"})]})}),r("div",{className:"flex items-center justify-end mt-4",children:[o&&e(b,{href:route("password.request"),className:"underline text-sm text-gray-600 hover:text-gray-900",children:"Forgot your password?"}),e(w,{className:"ml-4",processing:d,children:"Log in"})]})]})]})}export{E as default};
