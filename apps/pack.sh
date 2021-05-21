#!/bin/bash

mkdir -p target/entware/amd_apps/entware
mkdir -p target/entware/arm_apps/entware
cp -r -t target/entware/amd_apps/entware/ entware/etc entware/usr entware/config.ini entware/entware.lang entware/version
cp -r -t target/entware/arm_apps/entware/ entware/etc entware/usr entware/config.ini entware/entware.lang entware/version
#cp entware/version.x86_64 target/entware/amd_apps/entware/version
#cp entware/version.aarch64 target/entware/arm_apps/entware/version
cp -t target/entware/ tools/install-amd64 tools/install-arm64 tools/makeapp
mkdir -p target/entware/phpencode
cp tools/screw target/entware/phpencode
cd target/entware
./makeapp amd_apps/entware
./makeapp arm_apps/entware
