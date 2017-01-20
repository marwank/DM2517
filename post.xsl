<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:output indent="yes" method="html"/>
    <xsl:template match="/">
        <html>
            <head></head>
            <body>
                <h1><a href="welcome.php"><xsl:value-of select="//homeButton"/></a></h1>
                <xsl:apply-templates select="//image"/>
                <p>
                    <xsl:apply-templates select="//likes"/>
                    <xsl:if test="//isOwner">
                        <form method="post" action="post.php?id={//postID}">
                            <input type="submit" value="Like" name="like"/>
                        </form>
                    </xsl:if>
                </p>
                <p>
                    <xsl:apply-templates select="//dislikes"/>
                    <xsl:if test="//isOwner">
                        <form method="post" action="post.php?id={//postID}">
                            <input type="submit" value="Dislike" name="dislike"/>
                        </form>
                    </xsl:if>
                </p>
                <p>
                    <xsl:if test="//user">
                        <form method="post" action="post.php?id={//postID}">
                            <input type="text" accept="text/plain" name="addComment"/>
                            <input type="submit" value="{//addComment}" />
                        </form>
                    </xsl:if>
                </p>
                <p><xsl:apply-templates select="//comments"/></p>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="image">
        <img src="data:image/jpeg;base64,{.}"/>
    </xsl:template>

    <xsl:template match="likes">
        <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
    </xsl:template>

    <xsl:template match="dislikes">
        <xsl:value-of select="text"/>: <xsl:value-of select="value"/>
    </xsl:template>

    <xsl:template match="comments">
        <xsl:for-each select="comment">
            <a href="user.php?username={username}"><xsl:value-of select="username"/></a>: <xsl:value-of select="value"/>
            <xsl:if test="removeComment">
                <form method="post" action="post.php?id={//postID}">
                    <input type="hidden" name="removeComment" value="{commentID}"/>
                    <input type="submit" value="-"/>
                </form>
            </xsl:if>
            <br/>
        </xsl:for-each>
    </xsl:template>

</xsl:stylesheet>
