import{r as m,a as n,j as r,u as b,L as c,F as h}from"./app.fb91ff64.js";import{I as u}from"./InertiaTable.dfdd92d9.js";import{p as o,T as g,E as f,a as y}from"./TrenchDevsAdminLayout.8855af96.js";function v(e,t){if(e==null)return{};var l=k(e,t),i,a;if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);for(a=0;a<s.length;a++)i=s[a],!(t.indexOf(i)>=0)&&(!Object.prototype.propertyIsEnumerable.call(e,i)||(l[i]=e[i]))}return l}function k(e,t){if(e==null)return{};var l={},i=Object.keys(e),a,s;for(s=0;s<i.length;s++)a=i[s],!(t.indexOf(a)>=0)&&(l[a]=e[a]);return l}var d=m.exports.forwardRef(function(e,t){var l=e.color,i=l===void 0?"currentColor":l,a=e.size,s=a===void 0?24:a,p=v(e,["color","size"]);return n("svg",{ref:t,xmlns:"http://www.w3.org/2000/svg",width:s,height:s,viewBox:"0 0 24 24",fill:"none",stroke:i,strokeWidth:"2",strokeLinecap:"round",strokeLinejoin:"round",...p,children:[r("path",{d:"M12 19l7-7 3 3-7 7-3-3z"}),r("path",{d:"M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"}),r("path",{d:"M2 2l7.586 7.586"}),r("circle",{cx:"11",cy:"11",r:"2"})]})});d.propTypes={color:o.exports.string,size:o.exports.oneOfType([o.exports.string,o.exports.number])};d.displayName="PenTool";const x=d;function z(){const{data:e}=b().props;return r(g,{children:n("div",{className:"card",children:[r("div",{className:"card-header",children:"Blogs"}),n("div",{className:"card-body",children:[r("div",{className:"row pb-3",children:r("div",{className:"col text-right",children:n(c,{href:"/dashboard/blogs/upsert",className:"btn btn-sm btn-success",children:[r(x,{color:"white",size:14}),r("span",{className:"ml-1",children:"Create"})]})})}),r(u,{links:e.links,rows:e.data,columns:[{key:"primary_image_url",label:"Image",render:t=>r("img",{className:"img-thumbnail img-fluid",style:{maxHeight:"50px"},src:t.primary_image_url,alt:t.title})},{key:"id",label:"ID"},{key:"title",label:"Title"},{key:"slug",label:"Slug"},{key:"status",label:"Status"},{key:"publication_date",label:"Publication Date"},{key:"created_at",label:"Created At"},{key:"",label:"Actions",render:t=>n(h,{children:[r(c,{href:`/dashboard/blogs/upsert/${t.id}`,className:"btn btn-warning",children:r(f,{size:12})}),r(c,{href:`/dashboard/blogs/preview/${t.id}`,className:"ml-2 btn btn-info",children:r(y,{size:12})})]})}]})]})]})})}export{z as default};
