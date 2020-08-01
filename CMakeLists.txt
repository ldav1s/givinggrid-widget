cmake_minimum_required(VERSION 3.17.0)
project(givinggrid-widget-plugin VERSION 1.0.2 LANGUAGES NONE)
set(PARTS header.php.in plugin.php)
set(PLUGIN_TPL ${CMAKE_BINARY_DIR}/givinggrid-widget-plugin.php.in)
set(PLUGIN_TPL_TARGET ${CMAKE_BINARY_DIR}/givinggrid-widget-plugin.php)

function(cat IN_FILE OUT_FILE)
  file(READ ${IN_FILE} CONTENTS)
  file(APPEND ${OUT_FILE} "${CONTENTS}")
endfunction()

# Prepare a temporary file to "cat" to:
file(TOUCH ${PLUGIN_TPL})

# Call the "cat" function for each input file
foreach(PART ${PARTS})
  cat(${PART} ${PLUGIN_TPL})
endforeach()

configure_file(${PLUGIN_TPL} ${PLUGIN_TPL_TARGET} @ONLY)

set(DEST ${CMAKE_BINARY_DIR}/${PROJECT_NAME})
file(MAKE_DIRECTORY ${DEST})
install(FILES ${PLUGIN_TPL_TARGET} DESTINATION ${DEST})
add_custom_target(create_zip COMMAND
    ${CMAKE_COMMAND} -E tar "cfv" "${PROJECT_NAME}.zip" --format=zip
     "${DEST}")
