/**
 * public
 */

$(function(){
    function makeNode(_text,_href,nodeName,nowName){
        var node={
            text:_text,
            href: _href,
        };
        if(nodeName==nowName)
            node.backColor="#F5F5F5";
        return node;
    }


    function getNavTree(treeId,nodeName) {
        // Some logic to retrieve, or generate tree structure

        // backColor:"#F5F5F5",

        var node_news=makeNode('资讯管理','/news/index','news',nodeName);
        var node_company=makeNode('企业招聘','/company/index','company',nodeName);
        var node_course=makeNode('课程管理','/course/index','course',nodeName);


        var node_user=makeNode('员工账号','/user/index','user',nodeName);
        var node_role=makeNode('用户角色','/role/index','role',nodeName);
        var node_dict=makeNode('数据字典','/dict/index','dict',nodeName);
        var node_resource=makeNode('资源配置','/resource/index','resource',nodeName);
        var node_columns=makeNode('配置设定','/columns/index','columns',nodeName);


        var node_userlog=makeNode('登录日志','/userlog/index','userlog',nodeName);
        var node_syslog=makeNode('操作日志','/syslog/index','syslog',nodeName);


        var node_myinfo=makeNode('我的信息','/user/myinfo','myinfo',nodeName);
        var node_changepass=makeNode('修改密码','/user/changepass','changepass',nodeName);


        var m_nodes_news={
            text: "资讯管理",
            nodes: [
                node_news
            ],
            state:{selected:false,expanded:false}
        };

        var m_nodes_company={
            text: "企业招聘",
            nodes: [
                node_company
            ],
            state:{selected:false,expanded:false}
        };


        var m_nodes_course={
            text: "课程管理",
            nodes: [
                node_course
            ],
            state:{selected:false,expanded:false}
        };


        var m_nodes_basic={
            text: "基础数据",
            nodes: [
                node_user,node_role,node_dict,node_resource,node_columns
            ],
            state:{selected:false,expanded:false}
        };


        var m_nodes_sys={
            text: "系统管理",
            nodes: [
                node_userlog,node_syslog
            ],
            state:{selected:false,expanded:false}
        };

        var m_nodes_my={
            text: "我的信息",
            nodes: [
                node_myinfo,node_changepass
            ],
            state:{selected:false,expanded:false}
        };

        if(treeId==1){
            m_nodes_news['state']={selected:true,expanded:true};

        }else if(treeId==2){
            m_nodes_company['state']={selected:true,expanded:true};

        }else if(treeId==3){
            m_nodes_course['state']={selected:true,expanded:true};

        }else if(treeId==4){
            m_nodes_basic['state']={selected:true,expanded:true};
        }else if(treeId==5){
            m_nodes_sys['state']={selected:true,expanded:true};
        }else if(treeId==6){
            m_nodes_my['state']={selected:true,expanded:true};
        }
        else{
            m_nodes_news['state']={selected:true,expanded:true};
        }

        var tree = [
            m_nodes_news,m_nodes_company,m_nodes_course,m_nodes_basic,m_nodes_sys,m_nodes_my
        ];

        return tree;
    }


    $('#tree').treeview({data: getNavTree(treeId,nodeName),
        showCheckbox: false,
        showBorder:false,
        levels:1,
        onNodeSelected: function (event, data) {
            if(data.href!=''&&typeof(data.href)!='undefined')
                window.location.href=data.href;
        },
        toggleNodeChecked:[1,{silent: true}],
    });


})
