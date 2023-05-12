export default "/**\n * http: */\n\n@export ecgl.lambert.vertex\n\n@import ecgl.common.transformUniforms\n\n@import ecgl.common.uv.header\n\n\n@import ecgl.common.attributes\n\n@import ecgl.common.wireframe.vertexHeader\n\n#ifdef VERTEX_COLOR\nattribute vec4 a_Color : COLOR;\nvarying vec4 v_Color;\n#endif\n\n\n@import ecgl.common.vertexAnimation.header\n\n\nvarying vec3 v_Normal;\nvarying vec3 v_WorldPosition;\n\nvoid main()\n{\n @import ecgl.common.uv.main\n\n @import ecgl.common.vertexAnimation.main\n\n\n gl_Position = worldViewProjection * vec4(pos, 1.0);\n\n v_Normal = normalize((worldInverseTranspose * vec4(norm, 0.0)).xyz);\n v_WorldPosition = (world * vec4(pos, 1.0)).xyz;\n\n#ifdef VERTEX_COLOR\n v_Color = a_Color;\n#endif\n\n @import ecgl.common.wireframe.vertexMain\n}\n\n@end\n\n\n@export ecgl.lambert.fragment\n\n#define LAYER_DIFFUSEMAP_COUNT 0\n#define LAYER_EMISSIVEMAP_COUNT 0\n\n#define NORMAL_UP_AXIS 1\n#define NORMAL_FRONT_AXIS 2\n\n@import ecgl.common.uv.fragmentHeader\n\nvarying vec3 v_Normal;\nvarying vec3 v_WorldPosition;\n\nuniform sampler2D diffuseMap;\nuniform sampler2D detailMap;\n\n@import ecgl.common.layers.header\n\nuniform float emissionIntensity: 1.0;\n\nuniform vec4 color : [1.0, 1.0, 1.0, 1.0];\n\nuniform mat4 viewInverse : VIEWINVERSE;\n\n#ifdef ATMOSPHERE_ENABLED\nuniform mat4 viewTranspose: VIEWTRANSPOSE;\nuniform vec3 glowColor;\nuniform float glowPower;\n#endif\n\n#ifdef AMBIENT_LIGHT_COUNT\n@import clay.header.ambient_light\n#endif\n#ifdef AMBIENT_SH_LIGHT_COUNT\n@import clay.header.ambient_sh_light\n#endif\n\n#ifdef DIRECTIONAL_LIGHT_COUNT\n@import clay.header.directional_light\n#endif\n\n#ifdef VERTEX_COLOR\nvarying vec4 v_Color;\n#endif\n\n\n@import ecgl.common.ssaoMap.header\n\n@import ecgl.common.bumpMap.header\n\n@import clay.util.srgb\n\n@import ecgl.common.wireframe.fragmentHeader\n\n@import clay.plugin.compute_shadow_map\n\nvoid main()\n{\n#ifdef SRGB_DECODE\n gl_FragColor = sRGBToLinear(color);\n#else\n gl_FragColor = color;\n#endif\n\n#ifdef VERTEX_COLOR\n #ifdef SRGB_DECODE\n gl_FragColor *= sRGBToLinear(v_Color);\n #else\n gl_FragColor *= v_Color;\n #endif\n#endif\n\n @import ecgl.common.albedo.main\n\n @import ecgl.common.diffuseLayer.main\n\n gl_FragColor *= albedoTexel;\n\n vec3 N = v_Normal;\n#ifdef DOUBLE_SIDED\n vec3 eyePos = viewInverse[3].xyz;\n vec3 V = normalize(eyePos - v_WorldPosition);\n\n if (dot(N, V) < 0.0) {\n N = -N;\n }\n#endif\n\n float ambientFactor = 1.0;\n\n#ifdef BUMPMAP_ENABLED\n N = bumpNormal(v_WorldPosition, v_Normal, N);\n ambientFactor = dot(v_Normal, N);\n#endif\n\n vec3 N2 = vec3(N.x, N[NORMAL_UP_AXIS], N[NORMAL_FRONT_AXIS]);\n\n vec3 diffuseColor = vec3(0.0, 0.0, 0.0);\n\n @import ecgl.common.ssaoMap.main\n\n#ifdef AMBIENT_LIGHT_COUNT\n for(int i = 0; i < AMBIENT_LIGHT_COUNT; i++)\n {\n diffuseColor += ambientLightColor[i] * ambientFactor * ao;\n }\n#endif\n#ifdef AMBIENT_SH_LIGHT_COUNT\n for(int _idx_ = 0; _idx_ < AMBIENT_SH_LIGHT_COUNT; _idx_++)\n {{\n diffuseColor += calcAmbientSHLight(_idx_, N2) * ambientSHLightColor[_idx_] * ao;\n }}\n#endif\n#ifdef DIRECTIONAL_LIGHT_COUNT\n#if defined(DIRECTIONAL_LIGHT_SHADOWMAP_COUNT)\n float shadowContribsDir[DIRECTIONAL_LIGHT_COUNT];\n if(shadowEnabled)\n {\n computeShadowOfDirectionalLights(v_WorldPosition, shadowContribsDir);\n }\n#endif\n for(int i = 0; i < DIRECTIONAL_LIGHT_COUNT; i++)\n {\n vec3 lightDirection = -directionalLightDirection[i];\n vec3 lightColor = directionalLightColor[i];\n\n float shadowContrib = 1.0;\n#if defined(DIRECTIONAL_LIGHT_SHADOWMAP_COUNT)\n if (shadowEnabled)\n {\n shadowContrib = shadowContribsDir[i];\n }\n#endif\n\n float ndl = dot(N, normalize(lightDirection)) * shadowContrib;\n\n diffuseColor += lightColor * clamp(ndl, 0.0, 1.0);\n }\n#endif\n\n gl_FragColor.rgb *= diffuseColor;\n\n#ifdef ATMOSPHERE_ENABLED\n float atmoIntensity = pow(1.0 - dot(v_Normal, (viewTranspose * vec4(0.0, 0.0, 1.0, 0.0)).xyz), glowPower);\n gl_FragColor.rgb += glowColor * atmoIntensity;\n#endif\n\n @import ecgl.common.emissiveLayer.main\n\n @import ecgl.common.wireframe.fragmentMain\n}\n\n@end";
