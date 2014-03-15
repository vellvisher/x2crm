if [ -z "$1" ]
  then
    echo "No password supplied"
    exit 1
fi
for f in *.enc
do
    openssl aes-256-ecb -pass pass:$1 -d < $f > ${f%.enc}
    rm $f
done
