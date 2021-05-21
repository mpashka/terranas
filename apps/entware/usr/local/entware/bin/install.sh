#!/bin/bash

orig_path="$PATH"
export PATH=$PATH:/usr/local/entware/bin

if [[ ! -d /mnt/md0/appdata/entware ]] ; then
  mkdir /mnt/md0/appdata/entware
fi

if [[ ! -f /opt ]] ; then
  ln -s /mnt/md0/appdata/entware /opt
fi

arch="$(uname -m)"
case "$arch" in
  aarch64)
    release=aarch64-k3.10
    ;;
  x86_64)
    release=x64-k3.2
    ;;
  *)
    echo "Unknown architecture $arch"
    exit 1
esac

wget -O - "http://bin.entware.net/${release}/installer/generic.sh" | /bin/sh

export PATH=/opt/bin:/opt/sbin:$orig_path
opkg update
