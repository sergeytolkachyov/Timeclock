PHPUNIT=`which phpunit`
PHPDOC=`which phpdoc`
DOXYGEN=`which doxygen`
PHPCS=`which phpcs`
SVN=`which svn`
SVN_SERVER=https://svn.hugllc.com
SRC=`pwd`
DEST="${SRC}/Joomla/"

all: check copy_from_dev

copy_from_dev: check copy-com_timeclock copy-mod_timeclockinfo copy-plg_user_timeclock

copy-com_timeclock:
	rsync -av --delete --include="contrib/index.html" --exclude="contrib/*" ${SRC}/com_timeclock/site/* ${DEST}/components/com_timeclock/
	rsync -av --delete ${SRC}/com_timeclock/admin/* ${DEST}/administrator/components/com_timeclock/
	rsync -av ${SRC}/com_timeclock/admin/languages/en-GB/* ${DEST}/administrator/language/en-GB/
	rsync -av ${SRC}/com_timeclock/site/languages/en-GB/* ${DEST}/language/en-GB/

copy-mod_timeclockinfo:
	rsync -av --delete ${SRC}/mod_timeclockinfo/* ${DEST}/modules/mod_timeclockinfo/
	rsync -av ${SRC}/mod_timeclockinfo/language/en-GB/* ${DEST}/language/en-GB/
	
copy-plg_user_timeclock:
	rsync -av --delete ${SRC}/plg_user_timeclock/* ${DEST}/plugins/user/timeclock/
	rsync -av ${SRC}/plg_user_timeclock/language/en-GB/* ${DEST}/administrator/language/en-GB/

check:
	@if [[ ! -d "Joomla/components" || ! -d "Joomla/administrator/components" ]]; then \
	    echo "Joomla 3.x needs to be installed in the Joomla subdirectory"; \
	    exit 1; \
	fi;
	@./fixini.php
	
package: rel/pkg_timeclock.zip clean

	
rel/pkg_timeclock.zip: build/pkg_timeclock/pkg_timeclock.xml build/pkg_timeclock/packages/com_timeclock.zip build/pkg_timeclock/packages/plg_user_timeclock.zip build/pkg_timeclock/packages/mod_timeclockinfo.zip 
	mkdir -p rel
	cd build; zip -r ../rel/pkg_timeclock.zip pkg_timeclock

build/pkg_timeclock/packages/com_timeclock.zip:
	mkdir -p build/pkg_timeclock/packages
	zip -r build/pkg_timeclock/packages/com_timeclock.zip com_timeclock

build/pkg_timeclock/packages/plg_user_timeclock.zip:
	mkdir -p build/pkg_timeclock/packages
	zip -r build/pkg_timeclock/packages/plg_user_timeclock.zip plg_user_timeclock

build/pkg_timeclock/packages/mod_timeclockinfo.zip:
	mkdir -p build/pkg_timeclock/packages
	zip -r build/pkg_timeclock/packages/mod_timeclockinfo.zip mod_timeclockinfo

build/pkg_timeclock/pkg_timeclock.xml:
	mkdir -p build/pkg_timeclock
	cp pkg_timeclock.xml build/pkg_timeclock/

clean:
	rm -Rf build/*

dist-clean: clean
	rm -Rf rel/*.zip 
	
joomla-clean:
	rm -Rf Joomla/components/com_timeclock Joomla/administrator/components/com_timeclock
	
style:
	${PHPCS} -n com_timeclock plg_user_timeclock mod_timeclockinfo

bin:
	$(MAKE) -C bin

tests/unit:
	svn co https://github.com/joomla/joomla-cms/trunk/tests/unit

phpgraph: rel/phpgraph.zip

rel/phpgraph.zip: build/phpgraph/master.zip
	rm -Rf build/phpgraph/phpgraphlib-master
	cd build/phpgraph; unzip master.zip
	cp -f build/phpgraph/phpgraphlib-master/*.php build/phpgraph/phpgraph/
	cp -f build/phpgraph/phpgraphlib-master/LICENSE* build/phpgraph/phpgraph/
	cp -f build/phpgraph/phpgraphlib-master/README* build/phpgraph/phpgraph/
	cd build/phpgraph && zip -r ../../rel/phpgraph.zip phpgraph/
	
build/phpgraph/master.zip:
	mkdir -p build/phpgraph/phpgraph
	wget https://github.com/elliottb/phpgraphlib/archive/master.zip -O build/phpgraph/master.zip
	
test: check bin/phpunit all
	@./bin/phpunit

phpexcel: rel/phpexcel.zip

rel/phpexcel.zip: build/phpexcel/master.zip
	rm -Rf build/phpexcel/PHPExcel-master
	cd build/phpexcel; unzip master.zip
	cp -Rf build/phpexcel/PHPExcel-master/Classes/* build/phpexcel/phpexcel/
	cp -f build/phpexcel/PHPExcel-master/license* build/phpexcel/phpexcel/
	cp -f build/phpexcel/PHPExcel-master/changelog* build/phpexcel/phpexcel/
	cd build/phpexcel && zip -r ../../rel/phpexcel.zip phpexcel/
	
build/phpexcel/master.zip:
	mkdir -p build/phpexcel/phpexcel
	wget https://github.com/PHPOffice/PHPExcel/archive/master.zip -O build/phpexcel/master.zip
	
.PHONY: all check package style clean copy_from_dev bin phpgraph phpexcel
