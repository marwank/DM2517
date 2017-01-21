<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:output indent="yes" method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <style>
                    @media (max-width: 1000px) {
                    body {background-color: powderblue;}

                    .post {display: block; margin-left: auto; margin-right: auto;}

                    h1 {display: inline-block; margin-left: auto; margin-right: auto;}

                    .homeLink {display:inline-block; position: absolute; top:0; left:0;}

                    .flag {display: inline-block; position: absolute; top:0; right:0;}

                    .center-block {display: block; text-align: center;}

                    .like {display: block; text-align: center;}

                    .tags {display: none;}

                    .likes {display: block;}

                    .pic-likes-tags {text-align: center; margin-left: auto; margin-right: auto;}

                    .langflag {height: 80px; width: 80px;}

                    .likebtn {width: 50px; height: 50px;}

                    .dislikebtn {width: 50px; height: 50px;}
                    }

                    @media (min-width: 1000px) {

                    body {background-color: blanchedalmond;}

                    .post {display: block; margin-left: auto; margin-right: auto;}

                    h1 {display: inline-block; margin-left: auto; margin-right: auto;}

                    .homeLink {display:inline-block; position: absolute; top:0; left:0;}

                    .flag {display: inline-block; position: absolute; top:0; right:0;}

                    .center-block {display: block; text-align: center;}

                    .like {display: block; text-align: center;}

                    .tags {display: inline-block;}

                    .pic-likes-tags {display: block; text-align: center; margin-left: auto; margin-right: 50px;}

                    .likes {display: inline-block;}

                    .langflag {height: 40px; width: 40px;}

                    .likebtn {width: 30px; height: 30px;}
                    .dislikebtn {width: 30px; height: 30px;}
                    }
                </style>
            </head>
            <body>
                <h1><a class="homeLink" href="welcome.php"><xsl:value-of select="//homeButton"/></a></h1>
                <form class="flag" method="get" action="post.php">
                    <input type="hidden" name="id" value="{//postID}"/>
                    <input type="hidden" name="lang" value="{//changeLang}"/>
                    <input class="langflag" type="image" src="{//langFlag}" alt="{//changeLang}"/>
                </form>

                <div class="pic-likes-tags">
                    <xsl:if test="//isOwner">
                        <div class="tags">
                            <form method="post" action="post.php?id={//postID}">
                                <input type="text" accept="text/plain" name="addTag"/>
                                <input type="submit" value="{//addTag}" />
                            </form>
                            <xsl:apply-templates select="//tags"/>
                        </div>
                    </xsl:if>

                    <xsl:apply-templates select="//image"/>

                    <div class="likes">
                        <div class="like">
                            <xsl:if test="//user">
                                <form style="display:inline-block;" method="post" action="post.php?id={//postID}">
                                    <input type="hidden" name="like"/>
                                    <input class="likebtn" type="image" src="like.png" alt="Like"/>
                                </form>
                            </xsl:if>
                            <xsl:apply-templates select="//likes"/>
                        </div>

                        <div class="like">
                            <xsl:if test="//user">
                                <form style="display:inline-block;" method="post" action="post.php?id={//postID}">
                                    <input type="hidden" name="dislike"/>
                                    <input class="dislikebtn" type="image" src="dislike.png" alt="Dislike"/>
                                </form>
                            </xsl:if>
                            <xsl:apply-templates select="//dislikes"/>
                        </div>
                    </div>

                </div>
                <xsl:apply-templates select="//description"/>
                <xsl:if test="//isOwner">
                    <form class="center-block" method="post" action="post.php?id={//postID}">
                        <input type="text" accept="text/plain" name="editDescription"/>
                        <input type="submit" value="{//editDesc}"/>
                    </form>
                </xsl:if>

                <xsl:if test="//user">
                    <form class="center-block" method="post" action="post.php?id={//postID}">
                        <input type="textbox" accept="text/plain" name="addComment"/>
                        <input type="submit" value="{//addComment}" />
                    </form>
                </xsl:if>
                <xsl:apply-templates select="//comments"/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="image">
        <img src="data:image/jpeg;base64,{.}"/>
    </xsl:template>

    <xsl:template match="description">
        <p class="center-block"><xsl:value-of select="."/></p>
    </xsl:template>

    <xsl:template match="likes">
        <div style="display:inline-block;">
            <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
        </div>
    </xsl:template>

    <xsl:template match="dislikes">
        <div style="display:inline-block;">
            <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
        </div>
    </xsl:template>

    <xsl:template match="tags">
        <xsl:for-each select="tag">
            <div style="display:block;">
                <form style="display: inline-block; margin-left: 5px; margin-right: 5px;" method="post" action="post.php?id={//postID}">
                    <input type="hidden" name="removeTag" value="{.}"/>
                    <input type="image" width="15px" height="15px" src="minus.jpg" alt="-"/>
                </form>
                <a style="display: inline-block;" href="search.php?searchQuery={.}"><xsl:value-of select="."/></a>
            </div>
        </xsl:for-each>
    </xsl:template>

    <xsl:template match="comments">
        <xsl:for-each select="comment">
            <div class="center-block">
                <xsl:if test="removeComment">
                    <form style="display: inline-block;" method="post" action="post.php?id={//postID}">
                        <input type="hidden" name="removeComment" value="{commentID}"/>
                        <input style="margin-right: 5px;" type="image" width="15px" height="15px" src="minus.jpg" alt="-"/>
                    </form>
                </xsl:if>
                <a href="user.php?username={username}"><xsl:value-of select="username"/></a>: <xsl:value-of select="value"/>

            </div>
        </xsl:for-each>
    </xsl:template>

</xsl:stylesheet>
