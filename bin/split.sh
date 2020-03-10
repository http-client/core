#!/usr/bin/env bash

set -e
set -x

CURRENT_BRANCH="master"

function split()
{
    SHA1=`./bin/splitsh-lite --prefix=$1`
    git push $2 "$SHA1:refs/heads/$CURRENT_BRANCH" -f
}

function remote()
{
    git remote add $1 $2 || true
}

git pull origin $CURRENT_BRANCH

remote core git@github.com:http-client/core.git
remote aliyun git@github.com:http-client/aliyun.git

split 'src/Core' core
split 'src/Aliyun' aliyun
