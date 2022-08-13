import{b as r,a as t,j as e,H as o,L as l}from"./app.c0efc5b0.js";import{G as d,B as m}from"./Guest.8c6f4d67.js";function h({status:i}){const{post:n,processing:s}=r();return t(d,{children:[e(o,{title:"Email Verification"}),e("div",{className:"mb-4 text-sm text-gray-600",children:"Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another."}),i==="verification-link-sent"&&e("div",{className:"mb-4 font-medium text-sm text-green-600",children:"A new verification link has been sent to the email address you provided during registration."}),e("form",{onSubmit:a=>{a.preventDefault(),n("/verification-notification")},children:t("div",{className:"mt-4 flex items-center justify-between",children:[e(m,{processing:s,children:"Resend Verification Email"}),e(l,{href:"/logout",method:"post",as:"button",className:"underline text-sm text-gray-600 hover:text-gray-900",children:"Log Out"})]})})]})}export{h as default};
