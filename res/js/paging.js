function Pager(tableName, itemsPerPage) {
    this.tableName = tableName;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = 1;
    this.pages = 0;
    this.inited = false;
    this.range = 9; //Number of button you want to display
    
    this.showRecords = function(from, to) {        
        var rows = document.getElementById(tableName).rows;
        // i starts from 1 to skip table header row
        for (var i = 1; i < rows.length; i++) {
            if (i < from || i > to)  
                rows[i].style.display = 'none';
            else
                rows[i].style.display = '';
        }
    };
    
    this.showPage = function(pageNumber) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}
        
        var oldPageAnchor = document.getElementById('pg'+this.currentPage);
        oldPageAnchor.className = 'pg-normal';
        
        // Calculte range of page to display
        pager.showPageNav('pager', 'pageNavPosition', pageNumber);

        this.currentPage = pageNumber;
        var newPageAnchor = document.getElementById('pg'+this.currentPage);
        newPageAnchor.className = 'pg-selected';
        
        var newPageAnchorPrev = document.getElementById('pg_prev');
        if (this.currentPage == 1) {
            newPageAnchorPrev.className = 'pg-selected';
        } else {
            newPageAnchorPrev.className = 'pg-normal';
        }
        
        var newPageAnchorNext = document.getElementById('pg_next');
        if (this.currentPage == this.pages) {
            newPageAnchorNext.className = 'pg-selected';
        } else {
            newPageAnchorNext.className = 'pg-normal';
        }
        var from = (pageNumber - 1) * itemsPerPage + 1;
        var to = from + itemsPerPage - 1;
        this.showRecords(from, to);
    };   
    
    this.prev = function() {
        if (this.currentPage > 1)
            this.showPage(this.currentPage - 1);
    };
    
    this.next = function() {
        if (this.currentPage < this.pages) {
            this.showPage(this.currentPage + 1);
        }
    };                        
    
    this.init = function() {
        var rows = document.getElementById(tableName).rows;
		
        var records = (rows.length - 1); 
        this.pages = Math.ceil(records / itemsPerPage);
        this.inited = true;
    };

    this.showPageNav = function(pagerName, positionId, currentPage) {
    	if (! this.inited) {
    		alert("not inited");
    		return;
    	}

        var pageMin = 1;
        var pageMax = this.pages;
        var middle = Math.floor(this.range / 2);
        if ((currentPage - middle) <= 0) {
            pageMin = 1;
            pageMax = ((this.range - this.pages) < 0) ? this.range : this.pages;
        } else {
            if ((currentPage + middle) > this.pages) {
                pageMax = this.pages;
                pageMin = ((this.pages - this.range) > 0) ? ((this.pages - this.range) + 1) : 1;
            } else {
                var added_pageMin = (this.range % 2 === 1) ? 0 : 1;
                pageMax = currentPage + middle;
                pageMin = (currentPage - middle) + added_pageMin;
            }
        }
        
    	var element = document.getElementById(positionId);
    	var pagerHtml = '<div class=paging_client>';
        pagerHtml += '<span id="pg_prev" onclick="' + pagerName + '.prev();" class="pg-normal"> << </span>';
        for (var page = pageMin; page <= pageMax; page++) {
            pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';
        }
        pagerHtml += '<span id="pg_next" onclick="'+pagerName+'.next();" class="pg-normal"> >> </span>';  
        pagerHtml += '</div>';
        element.innerHTML = pagerHtml;
    };
}

