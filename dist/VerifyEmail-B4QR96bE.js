import{C as c,h as p,c as g,w as o,o as n,a as i,u as t,m as y,b as r,f as v,g as b,d as a,n as x,P as h,e as k}from"./app-D0toaANz.js";import{_}from"./GuestLayout-Db1X19dL.js";import{P as w}from"./PrimaryButton-D14vQ0iu.js";/* empty css            */import"./ApplicationLogo-HoWSwzf9.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const V={key:0,class:"mb-4 text-sm font-medium text-green-600"},B={class:"mt-4 flex items-center justify-between"},L={__name:"VerifyEmail",props:{status:{type:String}},setup(d){const l=d,s=c({}),m=()=>{s.post(route("verification.send"))},u=p(()=>l.status==="verification-link-sent");return(f,e)=>(n(),g(_,null,{default:o(()=>[i(t(y),{title:"Email Verification"}),e[2]||(e[2]=r("div",{class:"mb-4 text-sm text-gray-600"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1)),u.value?(n(),v("div",V," A new verification link has been sent to the email address you provided during registration. ")):b("",!0),r("form",{onSubmit:k(m,["prevent"])},[r("div",B,[i(w,{class:x({"opacity-25":t(s).processing}),disabled:t(s).processing},{default:o(()=>e[0]||(e[0]=[a(" Resend Verification Email ")])),_:1},8,["class","disabled"]),i(t(h),{href:f.route("logout"),method:"post",as:"button",class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"},{default:o(()=>e[1]||(e[1]=[a("Log Out")])),_:1},8,["href"])])],32)]),_:1}))}};export{L as default};
