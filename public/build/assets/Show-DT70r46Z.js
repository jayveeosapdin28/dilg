import{m as p,T as M,r as R,o as l,g as d,a as m,u as t,w as n,F as T,Q as f,Z as E,b as e,i as I,d as a,t as r,c as F,f as h,n as K}from"./app-CNfQWXbI.js";import{_ as O}from"./AuthenticatedLayout-CuPn9MrI.js";import{u as P}from"./useRole-CRUvodHo.js";import{u as Y}from"./useFormat-BFjS66bX.js";import{_ as j}from"./FileUploader-Czut1sqI.js";import{u as z}from"./useCrud-DtjOhyGI.js";import{_ as Q}from"./DataTable-2VJkDw1P.js";import"./useConfirmMessage-F1x9u0pX.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./dayjs.min-hwmDTkGa.js";import"./filepond-plugin-image-preview.esm-CI_uTiYr.js";import"./lodash-HEzghyR5.js";const Z={class:"pb-6"},q=e("i",{class:"bi bi-chevron-left mr-1"},null,-1),G={class:"h-full overflow-y-auto pb-24"},J={class:"max-w-5xl mx-auto px-6"},W={class:"font-semibold text-slate-800 text-4xl"},X={class:"text-slate-600 mt-4"},ee={class:"text-primary-400"},te={class:"text-primary-400"},se={class:"mt-12"},oe=e("h2",{class:"text-primary-400 mb-4 font-semibold"},"Instructions:",-1),le=["innerHTML"],ae={key:0,class:"mt-16 h-full overflow-y-auto space-y-4"},re=e("h2",{class:"text-primary-400 mb-4 font-semibold"},"Submitters List:",-1),ie={class:"flex items-center"},ne={class:"flex justify-end items-center"},de=["href"],me=e("i",{class:"bi bi-download"},null,-1),ce={key:1,class:"mt-14 bg-white space-y-8"},ue={key:0},_e=e("h2",{class:"text-primary-400 mb-4 font-semibold"},"My work:",-1),pe=["href"],fe={class:"bg-white rounded border border-primary-600 p-4 flex items-center gap-2"},he={class:"text-primary-600"},Te={__name:"Show",setup(ve){var x,k,g;const o=p(()=>f().props.data),v=p(()=>f().props.documents),c=p(()=>f().props.submitted),{hasRole:_}=P(),{date:b,mimeTypeIcon:$}=Y(),{submitForm:A}=z(),y=(x=o.value)==null?void 0:x.name;(k=o.value)==null||k.name;let s=M({task_id:(g=o.value)==null?void 0:g.id,file:null,remove_file:null});const U=()=>{s.remove_file=!0},H=async()=>{await A(s,"admin.task.submit",null,!0,!0).then(()=>{s.reset()})},L=[{label:"Name",field:"name"},{label:"Action",field:"file_url",align:"right"}];return(w,u)=>{const S=R("VBtn");return l(),d(T,null,[m(t(E),{title:t(y)},null,8,["title"]),m(O,null,{default:n(()=>{var V,C,D,B;return[e("div",Z,[m(t(I),{href:w.route("admin.tasks.index")},{default:n(()=>[m(S,{variant:"outlined",color:"primary"},{default:n(()=>[q,a(" Back ")]),_:1})]),_:1},8,["href"])]),e("div",G,[e("div",J,[e("h2",W,r(t(y)),1),e("div",X,[e("p",null,[a("Posted Date: "),e("b",null,r(t(b)(o.value.created_at)),1)]),e("p",null,[a("Due Date: "),e("b",null,r(t(b)(o.value.due_date)),1)]),e("p",null,[a("Priority: "),e("b",ee,r(o.value.priority.toUpperCase()),1)]),e("p",null,[a("Status: "),e("b",te,r((V=o.value.status)==null?void 0:V.toUpperCase()),1)])]),e("div",se,[oe,e("div",{class:"prose prose-slate",innerHTML:o.value.description},null,8,le)]),t(_)("Super Admin")||t(_)("Admin")?(l(),d("div",ae,[re,(C=v.value.data)!=null&&C.length?(l(),F(Q,{key:0,searchable:!1,class:"mb-12",columns:L,data:v.value,"filter-link":w.route("admin.tasks.show",o.value.id)},{column_name:n(({props:i})=>{var N;return[e("div",ie,r((N=i.user)==null?void 0:N.name),1)]}),column_file_url:n(({props:i})=>[e("div",ne,[e("a",{href:i.file_url,download:"SKYNOTA.docx",class:"flex gap-2 hover:bg-primary-600 hover:text-white items-center border border-primary-600 text-primary-600 px-3 py-1 rounded-full"},[me,a(" Download ")],8,de)])]),_:1},8,["data","filter-link"])):h("",!0)])):h("",!0),t(_)("User")?(l(),d("div",ce,[c.value?(l(),d("div",ue,[_e,e("a",{class:"text-primary-500 hover:underline cursor-pointer font-semibold",download:"SKYNOTA.docx",href:c.value.file_url,target:"_blank"},[e("div",fe,[e("i",{class:K([t($)((D=c.value.file)==null?void 0:D.mime_type),"text-2xl text-primary-500"])},null,2),e("span",he,r((B=c.value.file)==null?void 0:B.file_name),1)])],8,pe)])):(l(),d(T,{key:1},[(l(),F(j,{id:`${t(s).id}-id`,key:`${t(s).id}-key`,ref:"image_uploader",modelValue:t(s).file,"onUpdate:modelValue":[u[0]||(u[0]=i=>t(s).file=i),u[1]||(u[1]=i=>t(s).clearErrors("file"))],placeholder:"Drop or select document file here","model-files":t(s).file_url,onRemoveFile:U,"error-messages":t(s).errors.file},null,8,["id","modelValue","model-files","error-messages"])),m(S,{onClick:H,disabled:t(s).processing||!t(s).file,class:"",variant:"flat",color:"primary"},{default:n(()=>[a(" Submit Document ")]),_:1},8,["disabled"])],64))])):h("",!0)])])]}),_:1})],64)}}};export{Te as default};
