<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version="1.0">
<xsl:output indent="yes" method="html"/>
<xsl:template match="/">
   <html>
     <head></head>
     <body>
      <xsl:apply-templates select="//image"/>
     </body>
   </html>
</xsl:template>

<xsl:template match="image">
    <img src="data:image/jpeg;base64,{.}"/>
</xsl:template>

<xsl:template match="likes">
    
</xsl:template>


</xsl:stylesheet>
