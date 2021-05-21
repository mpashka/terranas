#!/bin/bash
export PATH=/opt/bin:/opt/sbin:$PATH
export LANG=en_US.utf8
# Hot fix for mc in tmux
if [[ "$TERM" == "screen" ]]; then
    export LC_CTYPE="POSIX"
fi
