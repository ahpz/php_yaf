#!/bin/bash
#author pengzhi
#desc:  odp php代码 一键部署
#desc: 从icode 拉取指定分支 代码到 本地临时目录(./output) 然后覆盖 odp4 相应文件 最后删除临时目录

#前端模块
APP_NAME=("haitao")

#ODP环境路径
ODP_PATH="/home/rd/odp"
#ODP_PATH="/home/work/script/pengzhi/deploy/odp"
#ODP_PATH="/home/users/pengzhi/projects/shell/deploy/odp"
#qa rd 环境
ENV=rd

#git仓库地址 
GIT_PATH="ssh://pengzhi@icode.baidu.com:8235/baidu/pay-kuajing-php"

function help()
{

  echo "Usage: sh deploy.sh -m <module>";
  echo "sh deploy.sh Deploy all "

  for((i=0; i<"${#APP_NAME[@]}"; i++))
  { 
      echo "sh deploy.sh -m ${i}  Deploy "${APP_NAME["${i}"]}
  } 

  
}
function deploy()
{
	local app=${1}
    git clone ${GIT_PATH}/${app}
	cd ${app}
	echo -e "\e[40;32mStart deploy ${app}\e[0m";

    [[ -d "${ODP_PATH}/app/${app}" ]] || mkdir -p "${ODP_PATH}/app/${app}"
	[[ -d "${ODP_PATH}/webroot/${app}" ]] || mkdir -p "${ODP_PATH}/webroot/${app}"
	[[ ! -d "${ODP_PATH}/conf/app/${app}" ]] && mkdir -p "${ODP_PATH}/conf/app/${app}"
	cp -r actions controllers library models Bootstrap.php script "${ODP_PATH}/app/${app}" #添加 script目录
	cp -r index.php "${ODP_PATH}/webroot/${app}"
	#默认线上配置 优先QA 配置文件
	cp -r conf/*.conf ${ODP_PATH}/conf/app/${app}

    #删除 rd qa 配置
	if [[ "xqa" == "x"${ENV} ]];then

		cp -r conf/*_${ENV}.conf ${ODP_PATH}/conf/app/${app} && find ${ODP_PATH}/conf/app/${app} -type f -name "*_${ENV}.conf" | sed -r -n 's/(.*)_qa(.*)/mv & \1\2/e'
		find ${ODP_PATH}/conf/app/${app} -type f -name "*_rd.conf" | xargs -n 1 rm -rf
	elif [[ "xrd" == "x"${ENV} ]];then

		cp -r conf/*_${ENV}.conf ${ODP_PATH}/conf/app/${app} && find ${ODP_PATH}/conf/app/${app} -type f -name "*_${ENV}.conf" | sed -r -n 's/(.*)_rd(.*)/mv & \1\2/e'
		find ${ODP_PATH}/conf/app/${app} -type f -name "*_qa.conf" | xargs -n 1 rm -rf
	else
		echo "the env is not setting, default online!"
	fi
	echo -e "\e[40;32mEnd deploy ${app}\e[0m" 
	cd ..

}
function deploy_phplib()
{

	echo -e "\e[40;32mStart deploy phplib\e[0m"
	[[ -d "${ODP_PATH}/php/phplib" ]] || mkdir -p "${ODP_PATH}/php/phplib"

	git clone ${GIT_PATH}"/phplib"
	cd phplib
	#[[ -d "../php/phplib" ]] || mkdir -p "../php/phplib"
	cp -r cross  utils "${ODP_PATH}/php/phplib/" 
	cd ..
	echo -e "\e[40;32mEnd deploy phplib \e[0m";
}

echo "*********************************exchange front deploy******************************************";


while getopts "m:h" opt
do
    case $opt in
        m) 
        loc=$OPTARG;
        MODULE=${APP_NAME["${loc}"]}
        ;;
		h) 
		help
		exit 1;;
        ?)
		help 
        exit 1;;
		*)
		help
		exit 1;;
    esac
done
echo "Deploy summary:"
echo "ODP PATH    :   ${ODP_PATH}"
echo "GIT PATH    :   ${GIT_PATH}"
echo "ENV         :　 ${ENV}"
echo "Feedback    :   pengzhi@baidu.com,crossborder@baidu.com"
echo ""
#创建临时输出目录
rm -rf ./output
[[ ! -d "./output" ]] && mkdir -p ./output

#进入运行目录
cd ./output
#部署

if [[ $MODULE"x" == "x" ]];then
    
    echo -n "Deploy all module "${APP_NAME[@]}" [Y/N]:"
    read is_all;
    if [[ $is_all"x" == "Nx" || $is_all"x" != "Yx" ]];then
        
        help;
        exit;
    fi; 

    for module in ${APP_NAME[@]}
    do
        if [[ $module == "phplib" ]];then
            deploy_phplib
        else
            deploy $module
        fi
    done
elif [[ $MODULE == "phplib" ]];then
    echo "-----";
    echo "Deploy module "${APP_NAME["${loc}"]}
    deploy_phplib;
else
    echo "Deploy module "${APP_NAME["${loc}"]}
    deploy $MODULE
fi

#退出目录
cd .. 
#rm -rf ./output
echo "Deploy success!"; 
echo "********************************************************************************************"
exit;
